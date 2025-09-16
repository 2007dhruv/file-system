@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-upload"></i> Upload Files to {{ $folder->name }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('files.store', $folder) }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="files" class="form-label">
                                <i class="fas fa-file"></i> Select Files <span class="text-danger">*</span>
                            </label>
                            <input id="files" type="file" class="form-control @error('files') is-invalid @enderror @error('files.*') is-invalid @enderror" 
                                   name="files[]" multiple required>
                            <div class="form-text">
                                <i class="fas fa-info-circle"></i> 
                                You can select multiple files. Maximum file size: 10GB per file. No limit on total files.
                            </div>
                            @error('files')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('files.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- File Preview Area -->
                        <div id="file-preview" class="mb-4" style="display: none;">
                            <h5><i class="fas fa-eye"></i> Selected Files</h5>
                            <div id="file-list" class="border rounded p-3 bg-light"></div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('folders.show', $folder) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Folder
                            </a>
                            <button type="submit" class="btn btn-success" id="upload-btn" disabled>
                                <i class="fas fa-upload"></i> Upload Files
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Upload Tips -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-lightbulb"></i> Upload Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>You can select multiple files at once using Ctrl+Click or Cmd+Click</li>
                        <li>Drag and drop is not supported in this version, use the file picker</li>
                        <li>Each file can be up to 10GB in size</li>
                        <li>All file types are supported</li>
                        <li>Files will be stored securely and can only be accessed by you and administrators</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('files').addEventListener('change', function() {
    const files = this.files;
    const previewDiv = document.getElementById('file-preview');
    const fileList = document.getElementById('file-list');
    const uploadBtn = document.getElementById('upload-btn');
    
    if (files.length > 0) {
        previewDiv.style.display = 'block';
        uploadBtn.disabled = false;
        
        let html = '<div class="row">';
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileSize = formatFileSize(file.size);
            
            html += `
                <div class="col-md-6 mb-2">
                    <div class="d-flex align-items-center p-2 border rounded">
                        <i class="fas fa-file text-info me-2"></i>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-truncate" style="max-width: 200px;" title="${file.name}">${file.name}</div>
                            <small class="text-muted">${fileSize}</small>
                        </div>
                    </div>
                </div>
            `;
        }
        html += '</div>';
        html += `<div class="mt-2"><strong>Total: ${files.length} files</strong></div>`;
        
        fileList.innerHTML = html;
    } else {
        previewDiv.style.display = 'none';
        uploadBtn.disabled = true;
    }
});

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>
@endpush
