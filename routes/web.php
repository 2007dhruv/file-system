<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Auth\RegisterController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes (login, register, etc.)
Auth::routes(['register' => false]); // Disable public registration

// Admin can register clients
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/register-client', [RegisterController::class, 'showClientRegistrationForm'])->name('admin.register-client');
    Route::post('/admin/register-client', [RegisterController::class, 'registerClient'])->name('admin.register-client.store');
    Route::get('/admin/clients', [ClientController::class, 'index'])->name('admin.clients.index');
});

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    
    // Folder routes
    Route::resource('folders', FolderController::class)->except(['edit', 'update']);
    
    // File routes
    Route::get('/folders/{folder}/files/create', [FileController::class, 'create'])->name('files.create');
    Route::post('/folders/{folder}/files', [FileController::class, 'store'])->name('files.store');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
});
