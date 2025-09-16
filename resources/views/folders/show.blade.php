@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Folder Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>
                <i class="fas fa-folder text-warning"></i>
                {{ $folder->name }}
            </h1>
            @if($folder->description)
                <p class="text-muted mb-0">{{ $folder->description }}</p>
            @endif
            <small class="text-muted">
                Owner: {{ $folder->user->name }} | 
                Created: {{ $folder->created_at->format('M d, Y g:i A') }}
            </small>
        </div>
        <div>
            @if(!Auth::user()->isAdmin() || $folder->user_id === Auth::id())
                <a href="{{ route('files.create', $folder) }}" class="btn btn-success">
                    <i class="fas fa-upload"></i> Upload Files
                </a>
            @endif
            <a href="{{ route('folders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Folders
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Files in Folder -->
    @if($folder->files->count() > 0)
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-file"></i> Files ({{ $folder->files->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-file"></i> File Name</th>
                                <th><i class="fas fa-info-circle"></i> Type</th>
                                <th><i class="fas fa-hdd"></i> Size</th>
                                <th><i class="fas fa-calendar"></i> Uploaded</th>
                                <th class="text-end"><i class="fas fa-cogs"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($folder->files as $file)
                                <tr>
                                    <td>
                                        <i class="fas fa-file text-info me-2"></i>
                                        <strong>{{ $file->original_name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $file->file_type }}</span>
                                    </td>
                                    <td>{{ $file->formatted_size }}</td>
                                    <td>{{ $file->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('files.download', $file) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @if(Auth::user()->isAdmin() || $file->user_id === Auth::id())
                                                <form action="{{ route('files.destroy', $file) }}" method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to delete this file?')" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="text-center">
            <div class="card">
                <div class="card-body py-5">
                    <i class="fas fa-file fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">No files in this folder</h3>
                    @if(!Auth::user()->isAdmin() || $folder->user_id === Auth::id())
                        <p class="text-muted mb-4">Upload your first files to get started.</p>
                        <a href="{{ route('files.create', $folder) }}" class="btn btn-success">
                            <i class="fas fa-upload"></i> Upload Files
                        </a>
                    @else
                        <p class="text-muted">This folder is empty.</p>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Folder Actions -->
    @if(Auth::user()->isAdmin() || $folder->user_id === Auth::id())
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-cogs"></i> Folder Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2">
                    @if(!Auth::user()->isAdmin() || $folder->user_id === Auth::id())
                        <a href="{{ route('files.create', $folder) }}" class="btn btn-success">
                            <i class="fas fa-upload"></i> Upload More Files
                        </a>
                    @endif
                    <form action="{{ route('folders.destroy', $folder) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this folder and all its files? This action cannot be undone.')" 
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Folder
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
