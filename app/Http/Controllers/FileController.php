<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Show the form for uploading files to a folder
     */
    public function create(Folder $folder)
    {
        $user = Auth::user();
        
        // Check if user can upload to this folder
        if (!$user->isAdmin() && $folder->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('files.create', compact('folder'));
    }

    /**
     * Store uploaded files
     */
    public function store(Request $request, Folder $folder)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'file|max:10240000', // 10GB max per file
        ]);

        $user = Auth::user();
        
        // Check if user can upload to this folder
        if (!$user->isAdmin() && $folder->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $uploadedFiles = [];
        
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                // Generate unique filename
                $filename = Str::uuid() . '.' . $uploadedFile->getClientOriginalExtension();
                
                // Store file
                $filePath = $uploadedFile->storeAs('uploads', $filename, 'public');
                
                // Create file record
                $file = File::create([
                    'name' => $filename,
                    'original_name' => $uploadedFile->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_type' => $uploadedFile->getClientMimeType(),
                    'file_size' => $uploadedFile->getSize(),
                    'folder_id' => $folder->id,
                    'user_id' => $user->id,
                ]);
                
                $uploadedFiles[] = $file;
            }
        }

        return redirect()->route('folders.show', $folder)
            ->with('success', count($uploadedFiles) . ' file(s) uploaded successfully.');
    }

    /**
     * Download a file
     */
    public function download(File $file)
    {
        $user = Auth::user();
        
        // Check if user can download this file
        if (!$user->isAdmin() && $file->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $filePath = storage_path('app/public/' . $file->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }
        
        return response()->download($filePath, $file->original_name);
    }

    /**
     * Remove the specified file
     */
    public function destroy(File $file)
    {
        $user = Auth::user();
        
        // Only owner or admin can delete file
        if (!$user->isAdmin() && $file->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete physical file
        Storage::disk('public')->delete($file->file_path);
        
        // Delete database record
        $file->delete();
        
        return back()->with('success', 'File deleted successfully.');
    }
}
