@extends('layouts.guest')

@section('title', 'Admin Login | Richfield Online Library')

@push('styles')
<style>
    .admin-icon {
        color: #dc3545;
    }
    
    .admin-card {
        border-left: 5px solid #dc3545;
    }
    
    .admin-title {
        color: #dc3545;
    }
</style>
@endpush

@section('content')
<div class="container container-custom flex-grow-1">
    <div class="row g-4">
        <!-- Welcome Column -->
        <div class="col-lg-5">
            <div class="card-custom card h-100 welcome-card admin-card">
                <div class="card-body p-4 text-center">
                    <div class="library-icon">
                        <i class="fas fa-user-shield admin-icon"></i>
                    </div>
                    <h2 class="welcome-message admin-title">Administrator Access</h2>
                    <p class="welcome-text">
                        Restricted access for library administrators only. Please use your authorized credentials 
                        to access the library management system.
                    </p>
                    <div class="mt-4">
                        <h5><i class="fas fa-exclamation-triangle admin-icon me-2"></i>Authorized Personnel Only</h5>
                        <p>Unauthorized access is prohibited</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Login Column -->
        <div class="col-lg-7">
            <div class="card-custom card">
                <div class="card-body p-4 p-md-5">
                    <h3 class="card-title text-center mb-4 admin-title"><i class="fas fa-user-shield me-2"></i>Administrator Login</h3>
                    
                    <!-- EMIHLE - the action needs to be updated to work with databse (same as otherone) -->
                    <form id="adminLoginForm" action="{{ route('admin.login.post') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope admin-icon me-2"></i>Admin Email</label>
                            <input type="email" class="form-control-custom form-control" id="email" name="email" placeholder="admin@richfield.ac.za" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="fas fa-lock admin-icon me-2"></i>Password</label>
                            <input type="password" class="form-control-custom form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        <button type="submit" name="login" class="btn btn-primary-custom btn-primary w-100 py-2 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">Student access? <a href="{{ route('login') }}" class="fw-bold">Student Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('adminLoginForm');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                alert('Please fill in all fields');
                return;
            }
            
            if (!email.includes('@')) {
                alert('Please enter a valid email address');
                return;
            }
            
            if (password.length < 8) {
                alert('Password must be at least 8 characters long');
                return;
            }
            
            // EMIHLE - need to submit to the databse here
            form.submit();
        });
    });
</script>
@endpush