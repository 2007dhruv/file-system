<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of all clients (admin only)
     */
    public function index()
    {
        $clients = User::where('role', 'client')
            ->withCount(['folders', 'files' => function($query) {
                $query->whereHas('folder');
            }])
            ->latest()
            ->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }
}
