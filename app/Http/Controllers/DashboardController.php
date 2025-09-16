<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            // Admin dashboard
            $totalUsers = User::where('role', 'client')->count();
            $totalFolders = Folder::count();
            $totalFiles = File::count();
            $recentFolders = Folder::with('user')->latest()->take(5)->get();
            $recentFiles = File::with(['user', 'folder'])->latest()->take(10)->get();
            
            return view('dashboard.admin', compact(
                'totalUsers', 'totalFolders', 'totalFiles', 'recentFolders', 'recentFiles'
            ));
        } else {
            // Client dashboard
            $totalFolders = $user->folders()->count();
            $totalFiles = File::where('user_id', $user->id)->count();
            $recentFolders = $user->folders()->latest()->take(5)->get();
            $recentFiles = File::where('user_id', $user->id)
                ->with('folder')
                ->latest()
                ->take(10)
                ->get();
            
            return view('dashboard.client', compact(
                'totalFolders', 'totalFiles', 'recentFolders', 'recentFiles'
            ));
        }
    }
}
