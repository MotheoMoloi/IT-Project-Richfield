 <!-- First need to connect to the database
    Then check if the form has been submitted
    Validate the name to check if it is empty etc
    Validate student number
    Validate email
    Validate password
    validate confirm password
    check if terms are accepted
    check if email or student number exist already -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Registration | Richfield Online Library</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style type="text/css">
        :root {
            --richfield-blue: #0056b3;
            --richfield-light-blue: #e6f0ff;
            --richfield-white: #ffffff;
            --richfield-dark-overlay: rgba(0, 30, 60, 0.6);
        }
        
        body {
            background: linear-gradient(var(--richfield-dark-overlay), var(--richfield-dark-overlay)), 
                        url("https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            margin-top: 3rem;
            margin-bottom: 3rem;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border: none;
            background: rgba(255, 255, 255, 0.95);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .welcome-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-left: 5px solid var(--richfield-blue);
        }
        
        .navbar {
            background-color: rgba(0, 86, 179, 0.9) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .navbar-brand, .nav-link {
            color: var(--richfield-white) !important;
        }
        
        .nav-link:hover {
            color: var(--richfield-light-blue) !important;
        }
        
        .btn-primary {
            background-color: var(--richfield-blue);
            border-color: var(--richfield-blue);
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: #004494;
            border-color: #004494;
        }
        
        .btn-outline-primary {
            color: var(--richfield-blue);
            border-color: var(--richfield-blue);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--richfield-blue);
            color: var(--richfield-white);
        }
        
        /* Link styling */
        a {
            color: var(--richfield-blue);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        a:hover {
            color: #003366;
            text-decoration: underline;
        }
        
        /* Form styling */
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            border-color: var(--richfield-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 86, 179, 0.25);
            background-color: white;
        }
        
        /* Alert styling */
        .alert {
            border-radius: 8px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.95);
        }
        
        /* Welcome message styling */
        .welcome-message {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--richfield-blue);
            margin-bottom: 1.5rem;
        }
        
        .welcome-text {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
        }
        
        .library-icon {
            font-size: 4rem;
            color: var(--richfield-blue);
            margin-bottom: 1.5rem;
        }
        
        /* Footer styling */
        footer {
            background-color: rgba(0, 86, 179, 0.9);
            color: var(--richfield-white);
            padding: 15px 0;
            margin-top: auto;
        }
        
        /* Password strength indicator */
        .password-strength {
            height: 5px;
            margin-bottom: 15px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .strength-0 { width: 0%; background-color: #dc3545; }
        .strength-1 { width: 25%; background-color: #dc3545; }
        .strength-2 { width: 50%; background-color: #ffc107; }
        .strength-3 { width: 75%; background-color: #28a745; }
        .strength-4 { width: 100%; background-color: #28a745; }
        
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .login-container {
                margin-top: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .welcome-message {
                font-size: 1.5rem;
            }
            
            .welcome-text {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">
                <i class="fas fa-book-open me-2"></i>Richfield Online Library
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}"><i class="fas fa-sign-in-alt me-1"></i> Student Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin_login') }}"><i class="fas fa-user-shield me-1"></i> Admin Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('sign_up') }}"><i class="fas fa-user-plus me-1"></i> Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container login-container flex-grow-1">
        <div class="row g-4">
            <!-- Welcome Column -->
            <div class="col-lg-5">
                <div class="card h-100 welcome-card">
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
                            <a href="{{ route('index') }}" class="btn btn-outline-primary mt-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Login Here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Registration Column -->
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title text-center mb-4"><i class="fas fa-user-plus text-primary me-2"></i>Create Your Account</h3>
                        
                        <form id="registrationForm">
                            <div class="mb-3">
                                <label for="name" class="form-label"><i class="fas fa-user text-primary me-2"></i>Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="student_number" class="form-label"><i class="fas fa-id-card text-primary me-2"></i>Student Number</label>
                                <input type="text" class="form-control" id="student_number" name="student_number" placeholder="Enter your student number" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label"><i class="fas fa-envelope text-primary me-2"></i>Student Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="student@richfield.ac.za" required>
                                <small class="text-muted">Use your Richfield student email address</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label"><i class="fas fa-lock text-primary me-2"></i>Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                                <div class="password-strength mt-2">
                                    <div class="strength-0" id="passwordStrength"></div>
                                </div>
                                <small id="passwordHelp" class="text-muted">Password must be at least 8 characters long</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label"><i class="fas fa-lock text-primary me-2"></i>Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                                <small id="confirmHelp" class="text-muted"></small>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a></label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </button>
                            
                            <div class="text-center">
                                <p class="mb-0">Already have an account? <a href="{{ route('index') }}" class="fw-bold">Login here</a></p>
                            </div>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <p class="mb-0">Staff member? <a href="{{ route('admin_login') }}" class="fw-bold">Administrator Login</a></p>
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

    <!-- Footer -->
    <footer class="mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> Richfield Graduate Institute of Technology. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Registration Form Validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirm_password = document.getElementById('confirm_password');
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
                
                // If all validations pass
                alert('Registration form is valid!');
                // form.submit();
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
</body>
</html>