@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-users"></i> All Clients</h1>
        <a href="{{ route('admin.register-client') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add New Client
        </a>
    </div>

    @if($clients->count() > 0)
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-list"></i> Registered Clients ({{ $clients->total() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user"></i> Client Name</th>
                                <th><i class="fas fa-envelope"></i> Email</th>
                                <th><i class="fas fa-folder"></i> Folders</th>
                                <th><i class="fas fa-file"></i> Files</th>
                                <th><i class="fas fa-calendar"></i> Registered</th>
                                <th><i class="fas fa-sign-in-alt"></i> Last Login</th>
                                <th class="text-end"><i class="fas fa-cogs"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 14px;">
                                                {{ strtoupper(substr($client->name, 0, 1)) }}
                                            </div>
                                            <strong>{{ $client->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <code>{{ $client->email }}</code>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $client->folders_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $client->files_count }}</span>
                                    </td>
                                    <td>{{ $client->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if($client->email_verified_at)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            @if($client->folders_count > 0)
                                                <a href="{{ route('folders.index') }}?user={{ $client->id }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="View Client's Folders">
                                                    <i class="fas fa-folder-open"></i>
                                                </a>
                                            @endif
                                            <button class="btn btn-sm btn-outline-info" 
                                                    onclick="showClientCredentials('{{ $client->name }}', '{{ $client->email }}')"
                                                    title="Show Login Info">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $clients->links() }}
            </div>
        </div>
    @else
        <div class="text-center">
            <div class="card">
                <div class="card-body py-5">
                    <i class="fas fa-users fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">No Clients Registered</h3>
                    <p class="text-muted mb-4">Start by registering your first client to manage their files.</p>
                    <a href="{{ route('admin.register-client') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Register First Client
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Client Credentials Modal -->
<div class="modal fade" id="credentialsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-key"></i> Client Login Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note:</strong> Passwords are encrypted and cannot be displayed. If the client forgot their password, you'll need to reset it manually in the database.
                </div>
                <div class="credential-info">
                    <div class="row">
                        <div class="col-6">
                            <strong><i class="fas fa-user"></i> Name:</strong><br>
                            <code id="modal-client-name"></code>
                        </div>
                        <div class="col-6">
                            <strong><i class="fas fa-envelope"></i> Email:</strong><br>
                            <code id="modal-client-email"></code>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong><i class="fas fa-lock"></i> Password:</strong><br>
                            <code class="text-muted">*** Hidden (Encrypted) ***</code>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showClientCredentials(name, email) {
    document.getElementById('modal-client-name').textContent = name;
    document.getElementById('modal-client-email').textContent = email;
    new bootstrap.Modal(document.getElementById('credentialsModal')).show();
}
</script>
@endpush
