@extends('layouts.guest')

@section('title', 'Student Registration | Richfield Online Library')

@section('content')
<div class="container container-custom flex-grow-1">
    <div class="row g-4">
        <!-- Welcome Column -->
        <div class="col-lg-5">
            <div class="card-custom card h-100 welcome-card">
                <div class="card-body p-4 text-center">
                    <div class="library-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h2 class="welcome-message">Student Registration</h2>
                    <p class="welcome-text">
                        Register for access to Richfield's Digital Library resources. 
                        As a registered student, you'll have 24/7 access to our extensive collection 
                        of academic materials, e-books, and research resources.
                    </p>
                    <div class="mt-4">
                        <h5><i class="fas fa-info-circle text-primary me-2"></i>Already have an account?</h5>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary mt-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Here
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Registration Column -->
        <div class="col-lg-7">
            <div class="card-custom card">
                <div class="card-body p-4 p-md-5">
                    <h3 class="card-title text-center mb-4"><i class="fas fa-user-plus text-primary me-2"></i>Create Your Account</h3>
                    
                    <!-- EMIHLE - u need to update the form somehow using database , dunno if it works yet-->
                    <form id="registrationForm" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label"><i class="fas fa-user text-primary me-2"></i>Full Name</label>
                            <input type="text" class="form-control-custom form-control" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="student_number" class="form-label"><i class="fas fa-id-card text-primary me-2"></i>Student Number</label>
                            <input type="text" class="form-control-custom form-control" id="student_number" name="student_number" placeholder="Enter your student number" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope text-primary me-2"></i>Student Email</label>
                            <input type="email" class="form-control-custom form-control" id="email" name="email" placeholder="student@richfield.ac.za" required>
                            <small class="text-muted">Use your Richfield student email address</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="fas fa-lock text-primary me-2"></i>Password</label>
                            <input type="password" class="form-control-custom form-control" id="password" name="password" placeholder="Create a password" required>
                            <div class="password-strength mt-2">
                                <div class="strength-0" id="passwordStrength"></div>
                            </div>
                            <small id="passwordHelp" class="text-muted">Password must be at least 8 characters long</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label"><i class="fas fa-lock text-primary me-2"></i>Confirm Password</label>
                            <input type="password" class="form-control-custom form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                            <small id="confirmHelp" class="text-muted"></small>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a></label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom btn-primary w-100 py-2 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </button>
                        
                        <div class="text-center">
                            <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="fw-bold">Login here</a></p>
                        </div>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">Staff member? <a href="{{ route('admin.login') }}" class="fw-bold">Administrator Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Richfield Online Library - Terms of Use</h6>
                <p>By registering for an account, you agree to the following terms:</p>
                <ol>
                    <li>You must be a current Richfield student to register for an account.</li>
                    <li>Your account is for personal use only and must not be shared.</li>
                    <li>You are responsible for maintaining the confidentiality of your login credentials.</li>
                    <li>All library resources are protected by copyright and are for educational use only.</li>
                    <li>Misuse of library resources may result in account suspension.</li>
                </ol>
                <p>By creating an account, you acknowledge that you have read and agree to these terms.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const confirm_password = document.getElementById('password_confirmation');
        const passwordStrength = document.getElementById('passwordStrength');
        const confirmHelp = document.getElementById('confirmHelp');
        const form = document.getElementById('registrationForm');
        
        // Password strength indicator
        password.addEventListener('input', function() {
            const strength = checkPasswordStrength(password.value);
            passwordStrength.className = 'strength-' + strength;
        });
        
        // Confirm password validation
        confirm_password.addEventListener('input', function() {
            if (confirm_password.value !== password.value) {
                confirmHelp.textContent = "Passwords don't match";
                confirmHelp.style.color = "#dc3545";
            } else {
                confirmHelp.textContent = "Passwords match";
                confirmHelp.style.color = "#28a745";
            }
        });
        
        // Form validation before submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (password.value !== confirm_password.value) {
                confirmHelp.textContent = "Passwords must match";
                confirmHelp.style.color = "#dc3545";
                return;
            }
            
            if (password.value.length < 8) {
                alert('Password must be at least 8 characters long');
                return;
            }
            
            if (!document.getElementById('terms').checked) {
                alert('You must agree to the terms and conditions');
                return;
            }
            
            // If all validations pass, submit the form
            form.submit();
        });
        
        function checkPasswordStrength(password) {
            let strength = 0;
            
            // Length >= 8
            if (password.length >= 8) strength++;
            
            // Contains lowercase
            if (password.match(/[a-z]+/)) strength++;
            
            // Contains uppercase
            if (password.match(/[A-Z]+/)) strength++;
            
            // Contains number or special char
            if (password.match(/[0-9!@#$%^&*()]+/)) strength++;
            
            return strength;
        }
    });
</script>
@endpush