<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    /**
     * Display a listing of folders
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            // Admin can see all folders
            $folders = Folder::with(['user', 'files'])->paginate(10);
        } else {
            // Client can only see their own folders
            $folders = $user->folders()->with('files')->paginate(10);
        }
        
        return view('folders.index', compact('folders'));
    }

    /**
     * Show the form for creating a new folder
     */
    public function create()
    {
        return view('folders.create');
    }

    /**
     * Store a newly created folder
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Folder::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('folders.index')
            ->with('success', 'Folder created successfully.');
    }

    /**
     * Display the specified folder
     */
    public function show(Folder $folder)
    {
        $user = Auth::user();
        
        // Check if user can view this folder
        if (!$user->isAdmin() && $folder->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $folder->load('files', 'user');
        
        return view('folders.show', compact('folder'));
    }

    /**
     * Remove the specified folder
     */
    public function destroy(Folder $folder)
    {
        $user = Auth::user();
        
        // Only owner or admin can delete folder
        if (!$user->isAdmin() && $folder->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $folder->delete();
        
        return redirect()->route('folders.index')
            ->with('success', 'Folder deleted successfully.');
    }
}
