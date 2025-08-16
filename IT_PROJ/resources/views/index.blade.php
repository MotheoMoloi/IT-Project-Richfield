<!-- Still need to create the connection to the database in order for this to work -->
<!DOCTYPE html>
<html lang="en">
...
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Richfield Online Library</title>
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
            <a class="navbar-brand" href="{{ route('landing') }}">
                <i class="fas fa-book-open me-2"></i>Richfield Online Library
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('landing') }}"><i class="fas fa-sign-in-alt me-1"></i> Student Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin_login') }}"><i class="fas fa-user-shield me-1"></i> Admin Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sign_up') }}"><i class="fas fa-user-plus me-1"></i> Register</a>
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
                <div class="card">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title text-center mb-4"><i class="fas fa-user-graduate text-primary me-2"></i>Student Login</h3>
                        

                        
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label"><i class="fas fa-envelope text-primary me-2"></i>Student Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="student@richfield.ac.za" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label"><i class="fas fa-lock text-primary me-2"></i>Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('sign_up') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </a>
                                <a href="change_password.php" class="text-primary">
                                    <i class="fas fa-question-circle me-2"></i>Forgot Password?
                                </a>
                            </div>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <p class="mb-0">Staff access? <a href="{{ route('admin_login') }}" class="fw-bold">Administrator Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Richfield Graduate Institute of Technology. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>