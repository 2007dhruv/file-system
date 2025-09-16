@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">
                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
            </h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalUsers }}</h4>
                            <small>Total Clients</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalFolders }}</h4>
                            <small>Total Folders</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-folder fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalFiles }}</h4>
                            <small>Total Files</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('admin.register-client') }}" class="btn btn-light btn-sm">Add Client</a>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-plus fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Folders -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-folder"></i> Recent Folders</h5>
                </div>
                <div class="card-body">
                    @if($recentFolders->count() > 0)
                        <div class="list-group">
                            @foreach($recentFolders as $folder)
                                <a href="{{ route('folders.show', $folder) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-folder text-warning"></i>
                                        <strong>{{ $folder->name }}</strong>
                                        <br>
                                        <small class="text-muted">by {{ $folder->user->name }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $folder->files->count() }} files</span>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('folders.index') }}" class="btn btn-sm btn-outline-primary">View All Folders</a>
                        </div>
                    @else
                        <p class="text-muted">No folders yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Files -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-file"></i> Recent Files</h5>
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
                                        <small class="text-muted">
                                            in {{ $file->folder->name }} by {{ $file->user->name }}
                                        </small>
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
                        <p class="text-muted">No files yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
