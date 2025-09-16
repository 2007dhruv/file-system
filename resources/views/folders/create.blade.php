@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-plus"></i> Create New Folder</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('folders.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-folder"></i> Folder Name <span class="text-danger">*</span>
                            </label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autofocus 
                                   placeholder="Enter folder name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-info-circle"></i> Description (Optional)
                            </label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="3" 
                                      placeholder="Enter a brief description of this folder...">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('folders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Folders
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Folder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
