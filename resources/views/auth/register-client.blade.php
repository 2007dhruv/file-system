@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user-plus"></i> Register New Client</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <h5><i class="fas fa-check-circle"></i> {{ session('success') }}</h5>
                            @if(session('client_name'))
                                <hr>
                                <h6><i class="fas fa-key"></i> Client Login Credentials:</h6>
                                <div class="credential-box p-3 bg-light border rounded mt-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong><i class="fas fa-user"></i> Name:</strong><br>
                                            <code>{{ session('client_name') }}</code>
                                        </div>
                                        <div class="col-md-6">
                                            <strong><i class="fas fa-envelope"></i> Email:</strong><br>
                                            <code>{{ session('client_email') }}</code>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <strong><i class="fas fa-lock"></i> Password:</strong><br>
                                            <code class="text-danger">{{ session('client_password') }}</code>
                                        </div>
                                    </div>
                                    <div class="alert alert-warning mt-3 mb-0">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Important:</strong> Please share these credentials securely with the client. The password will not be shown again!
                                    </div>
                                </div>
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.register-client.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user"></i> Client Name <span class="text-danger">*</span>
                            </label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autofocus 
                                   placeholder="Enter client's full name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                            </label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required 
                                   placeholder="Enter client's email address">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Password <span class="text-danger">*</span>
                            </label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required 
                                   placeholder="Enter a secure password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-text">Password must be at least 8 characters long.</div>
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">
                                <i class="fas fa-lock"></i> Confirm Password <span class="text-danger">*</span>
                            </label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required 
                                   placeholder="Confirm the password">
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> The new client will be able to log in with these credentials and create folders to upload their files.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Register Client
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Instructions Card -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-question-circle"></i> Instructions</h5>
                </div>
                <div class="card-body">
                    <ol>
                        <li>Fill in the client's details above</li>
                        <li>Choose a secure password for the client</li>
                        <li>Share the login credentials with the client securely</li>
                        <li>The client will be able to:
                            <ul class="mt-2">
                                <li>Create folders for organizing their files</li>
                                <li>Upload multiple files to their folders</li>
                                <li>Download their own files</li>
                                <li>View only their own folders and files</li>
                            </ul>
                        </li>
                        <li>As an admin, you can view and download all client files</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
