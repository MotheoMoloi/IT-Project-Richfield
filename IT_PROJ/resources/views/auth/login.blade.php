@extends('layouts.guest')

@section('title', 'Richfield Online Library')

@section('content')
<div class="container container-custom flex-grow-1">
    <div class="row g-4">
        <!-- Welcome Column -->
        <div class="col-lg-5">
            <div class="card-custom card h-100 welcome-card">
                <div class="card-body p-4 text-center">
                    <div class="library-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <h2 class="welcome-message">Welcome to Richfield's Digital Library</h2>
                    <p class="welcome-text">
                        Access our extensive collection of academic resources, e-books, and research materials. 
                        The library is your gateway to knowledge and academic success.
                    </p>
                    <div class="mt-4">
                        <h5><i class="fas fa-clock text-primary me-2"></i>24/7 Online Access</h5>
                        <p>Physical Library: Mon-Fri 8AM-6PM</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Login Column -->
        <div class="col-lg-7">
            <div class="card-custom card">
                <div class="card-body p-4 p-md-5">
                    <h3 class="card-title text-center mb-4"><i class="fas fa-user-graduate text-primary me-2"></i>Student Login</h3>
                    
                    <!-- EMIHLE - another form to be databased somehow  -->
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope text-primary me-2"></i>Student Email</label>
                            <input type="email" class="form-control-custom form-control" id="email" name="email" placeholder="student@richfield.ac.za" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="fas fa-lock text-primary me-2"></i>Password</label>
                            <input type="password" class="form-control-custom form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary-custom btn-primary w-100 py-2 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('register.post') }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </a>
                            <a href="{{ route('password.change') }}" class="text-primary">
                                <i class="fas fa-question-circle me-2"></i>Forgot Password?
                            </a>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">Staff access? <a href="{{ route('admin.login.post') }}" class="fw-bold">Administrator Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection