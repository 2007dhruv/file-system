@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">
                <i class="fas fa-tachometer-alt"></i> My Dashboard
            </h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalFolders }}</h4>
                            <small>My Folders</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-folder fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalFiles }}</h4>
                            <small>My Files</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-bolt"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('folders.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Folder
                    </a>
                    <a href="{{ route('folders.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-folder-open"></i> View All Folders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- My Recent Folders -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-folder"></i> My Recent Folders</h5>
                </div>
                <div class="card-body">
                    @if($recentFolders->count() > 0)
                        <div class="list-group">
                            @foreach($recentFolders as $folder)
                                <a href="{{ route('folders.show', $folder) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-folder text-warning"></i>
                                        <strong>{{ $folder->name }}</strong>
                                        @if($folder->description)
                                            <br>
                                            <small class="text-muted">{{ Str::limit($folder->description, 50) }}</small>
                                        @endif
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $folder->files->count() }} files</span>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('folders.index') }}" class="btn btn-sm btn-outline-primary">View All My Folders</a>
                        </div>
                    @else
                        <p class="text-muted mb-3">You haven't created any folders yet.</p>
                        <a href="{{ route('folders.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Your First Folder
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- My Recent Files -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-file"></i> My Recent Files</h5>
                </div>
                <div class="card-body">
                    @if($recentFiles->count() > 0)
                        <div class="list-group">
                            @foreach($recentFiles as $file)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-file text-info"></i>
                                        <strong>{{ $file->original_name }}</strong>
                                        <br>
                                        <small class="text-muted">in {{ $file->folder->name }}</small>
                                    </div>
                                    <div>
                                        <span class="badge bg-secondary">{{ $file->formatted_size }}</span>
                                        <a href="{{ route('files.download', $file) }}" class="btn btn-sm btn-outline-primary ms-1">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No files uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
