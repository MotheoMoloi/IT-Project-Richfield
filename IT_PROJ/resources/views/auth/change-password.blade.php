@extends('layouts.app')

@section('title', 'Change Password - Richfield Online Library')

@push('styles')
<style>
    .password-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
    
    .form-title {
        color: var(--richfield-blue);
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 600;
    }
    
    .form-icon {
        color: var(--richfield-blue);
        font-size: 1.2rem;
        margin-right: 10px;
    }
    
    .password-strength {
        height: 5px;
        margin-top: 5px;
        background-color: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
    }
    
    .password-strength-bar {
        height: 100%;
        width: 0%;
        transition: width 0.3s ease, background-color 0.3s ease;
    }
    
    .password-requirements {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 10px;
    }
    
    .requirement {
        margin-bottom: 5px;
    }
    
    .requirement.met {
        color: #28a745;
    }
    
    .requirement.met::before {
        content: "\f00c";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        margin-right: 5px;
    }
    
    .requirement.unmet {
        color: #6c757d;
    }
    
    .requirement.unmet::before {
        content: "\f111";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        margin-right: 5px;
        font-size: 0.6rem;
    }
</style>
@endpush

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ Auth::guard('admin')->check() ? route('admin.dashboard') : route('user.dashboard') }}">
            <i class="fas fa-book-open me-2"></i>Richfield Library {{ Auth::guard('admin')->check() ? 'Admin' : '' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <span class="text-white me-auto">
                <strong>Change Password</strong>
            </span>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ Auth::guard('admin')->check() ? route('admin.dashboard') : route('user.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" style="border: none; background: none;">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endsection

@section('content')
<div class="container flex-grow-1 d-flex align-items-center justify-content-center">
    <div class="password-container">
        <h3 class="form-title">
            <i class="fas fa-key form-icon"></i>Change Your Password
        </h3>
        
        <!-- EMIHLE -  form action needs to be updated here too -->
        <form id="changePasswordForm" action="{{ route('password.change') }}" method="POST">
            @csrf
            <!-- Current Password -->
            <div class="mb-3">
                <label for="current_password" class="form-label">
                    <i class="fas fa-lock form-icon"></i>Current Password
                </label>
                <div class="input-group">
                    <input type="password" class="form-control-custom form-control" id="current_password" name="current_password" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <!-- New Password -->
            <div class="mb-3">
                <label for="new_password" class="form-label">
                    <i class="fas fa-key form-icon"></i>New Password
                </label>
                <div class="input-group">
                    <input type="password" class="form-control-custom form-control" id="new_password" name="new_password" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="password-strength">
                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                </div>
                <div class="password-requirements">
                    <div class="requirement unmet" id="lengthReq">At least 8 characters</div>
                    <div class="requirement unmet" id="uppercaseReq">At least 1 uppercase letter</div>
                    <div class="requirement unmet" id="lowercaseReq">At least 1 lowercase letter</div>
                    <div class="requirement unmet" id="numberReq">At least 1 number</div>
                    <div class="requirement unmet" id="specialReq">At least 1 special character</div>
                </div>
            </div>
            
            <!-- Confirm New Password -->
            <div class="mb-4">
                <label for="new_password_confirmation" class="form-label">
                    <i class="fas fa-check-circle form-icon"></i>Confirm New Password
                </label>
                <div class="input-group">
                    <input type="password" class="form-control-custom form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <div class="invalid-feedback" id="passwordMatchFeedback">
                    Passwords do not match
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary-custom btn-primary">
                    <i class="fas fa-save me-2"></i>Change Password
                </button>
                <a href="{{ Auth::guard('admin')->check() ? route('admin.dashboard') : route('user.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // i left the javascript the same cause idk what's going on here ngl 
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const toggleButtons = document.querySelectorAll('.toggle-password');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
        
        // Password strength checker
        const newPasswordInput = document.getElementById('new_password');
        const strengthBar = document.getElementById('passwordStrengthBar');
        const requirements = {
            length: document.getElementById('lengthReq'),
            uppercase: document.getElementById('uppercaseReq'),
            lowercase: document.getElementById('lowercaseReq'),
            number: document.getElementById('numberReq'),
            special: document.getElementById('specialReq')
        };
        
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Check length
            if (password.length >= 8) {
                strength += 20;
                requirements.length.classList.add('met');
                requirements.length.classList.remove('unmet');
            } else {
                requirements.length.classList.remove('met');
                requirements.length.classList.add('unmet');
            }
            
            // Check uppercase letters
            if (/[A-Z]/.test(password)) {
                strength += 20;
                requirements.uppercase.classList.add('met');
                requirements.uppercase.classList.remove('unmet');
            } else {
                requirements.uppercase.classList.remove('met');
                requirements.uppercase.classList.add('unmet');
            }
            
            // Check lowercase letters
            if (/[a-z]/.test(password)) {
                strength += 20;
                requirements.lowercase.classList.add('met');
                requirements.lowercase.classList.remove('unmet');
            } else {
                requirements.lowercase.classList.remove('met');
                requirements.lowercase.classList.add('unmet');
            }
            
            // Check numbers
            if (/[0-9]/.test(password)) {
                strength += 20;
                requirements.number.classList.add('met');
                requirements.number.classList.remove('unmet');
            } else {
                requirements.number.classList.remove('met');
                requirements.number.classList.add('unmet');
            }
            
            // Check special characters
            if (/[^A-Za-z0-9]/.test(password)) {
                strength += 20;
                requirements.special.classList.add('met');
                requirements.special.classList.remove('unmet');
            } else {
                requirements.special.classList.remove('met');
                requirements.special.classList.add('unmet');
            }
            
            // Update strength bar
            strengthBar.style.width = strength + '%';
            
            // Update color based on strength
            if (strength < 40) {
                strengthBar.style.backgroundColor = '#dc3545';
            } else if (strength < 80) {
                strengthBar.style.backgroundColor = '#ffc107';
            } else {
                strengthBar.style.backgroundColor = '#28a745';
            }
            
            // Check password match
            checkPasswordMatch();
        });
        
        // Confirm password match checker
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        const passwordMatchFeedback = document.getElementById('passwordMatchFeedback');
        
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        
        function checkPasswordMatch() {
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (newPassword && confirmPassword && newPassword !== confirmPassword) {
                confirmPasswordInput.classList.add('is-invalid');
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
            }
        }
        
        // Form submission
        const form = document.getElementById('changePasswordForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            const newPassword = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (newPassword !== confirmPassword) {
                confirmPasswordInput.classList.add('is-invalid');
                return;
            }
            
            // Check password strength (at least 4 requirements met)
            const metRequirements = document.querySelectorAll('.requirement.met').length;
            if (metRequirements < 4) {
                alert('Please ensure your password meets at least 4 of the 5 requirements.');
                return;
            }
            
            // Submit the form
            form.submit();
        });
    });
</script>
@endpush