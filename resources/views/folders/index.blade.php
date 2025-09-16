@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="fas fa-folder"></i> 
            @if(Auth::user()->isAdmin())
                All Folders
            @else
                My Folders
            @endif
        </h1>
        @if(Auth::user()->isClient())
            <a href="{{ route('folders.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Folder
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($folders->count() > 0)
        <div class="row">
            @foreach($folders as $folder)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-folder text-warning"></i>
                                {{ $folder->name }}
                            </h5>
                            @if(Auth::user()->isAdmin())
                                <span class="badge bg-info">{{ $folder->user->name }}</span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($folder->description)
                                <p class="card-text">{{ $folder->description }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="fas fa-file"></i>
                                    {{ $folder->files->count() }} files
                                </span>
                                <small class="text-muted">
                                    Created: {{ $folder->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group w-100">
                                <a href="{{ route('folders.show', $folder) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                @if(!Auth::user()->isAdmin() || $folder->user_id === Auth::id())
                                    <a href="{{ route('files.create', $folder) }}" class="btn btn-success">
                                        <i class="fas fa-upload"></i> Upload
                                    </a>
                                @endif
                                @if(Auth::user()->isAdmin() || $folder->user_id === Auth::id())
                                    <form action="{{ route('folders.destroy', $folder) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this folder and all its files?')" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $folders->links() }}
        </div>
    @else
        <div class="text-center">
            <div class="card">
                <div class="card-body py-5">
                    <i class="fas fa-folder fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">No folders found</h3>
                    @if(Auth::user()->isClient())
                        <p class="text-muted mb-4">Create your first folder to get started.</p>
                        <a href="{{ route('folders.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Folder
                        </a>
                    @else
                        <p class="text-muted">No client folders have been created yet.</p>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
