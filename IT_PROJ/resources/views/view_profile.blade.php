<!-- Need a connection to the database
 Fetch student data from the database -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Profile - Richfield Online Library</title>
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
            --richfield-red: #dc3545;
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
        
        .profile-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border: none;
            background: rgba(255, 255, 255, 0.95);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        
        .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .dropdown-item:hover {
            background-color: var(--richfield-light-blue);
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
        
        .user-info {
            color: white;
            margin-right: 15px;
        }
        
        /* Marquee styling */
        .marquee-container {
            background-color: rgba(0, 86, 179, 0.8);
            color: white;
            padding: 10px 0;
            margin-bottom: 20px;
        }
        
        .marquee-text {
            font-size: 1rem;
            margin: 0;
        }
        
        /* Profile form styling */
        .profile-form {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .profile-header {
            color: var(--richfield-blue);
            margin-bottom: 30px;
            position: relative;
        }
        
        .profile-header:after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100px;
            height: 3px;
            background-color: var(--richfield-blue);
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
            .profile-container {
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
            
            .user-info {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="user_dashboard.php">
                <i class="fas fa-book-open me-2"></i>Richfield Library
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <span class="user-info me-auto">
                    <strong>Welcome: </strong>
                </span>
                <span class="user-info">
                    <i class="fas fa-envelope me-1"></i>
                </span>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>My Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="view_profile.php"><i class="fas fa-user me-2"></i>View Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="edit_profile.php"><i class="fas fa-edit me-2"></i>Edit Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="change_password.php"><i class="fas fa-key me-2"></i>Change Password</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Marquee Announcement -->
    <div class="marquee-container">
        <div class="container">
            <p class="marquee-text">
                <i class="fas fa-info-circle me-2"></i>
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container profile-container flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="profile-header text-center mb-4">
                            <i class="fas fa-user-graduate me-2"></i>Student Profile Details
                        </h4>
                        
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <form class="profile-form">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="name" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="text" class="form-control" id="email" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="studentId" class="form-label">Student ID</label>
                                        <input type="text" class="form-control" id="studentId" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mobile" class="form-label">Mobile Number</label>
                                        <input type="text" class="form-control" id="mobile" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Residential Address</label>
                                        <textarea class="form-control" id="address" rows="3" disabled></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="program" class="form-label">Academic Program</label>
                                        <input type="text" class="form-control" id="program" disabled>
                                    </div>
                                    <div class="text-center mt-4">
                                        <a href="edit_profile.php" class="btn btn-primary px-4">
                                            <i class="fas fa-edit me-2"></i>Edit Profile
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Richfield Graduate Institute of Technology. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>