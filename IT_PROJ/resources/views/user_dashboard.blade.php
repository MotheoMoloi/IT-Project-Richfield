  <!-- Would haev to redirect to login if not authentictated
   then need to make a connection to the database
   Would need to get the user information as well
   Fetch the user details
   count borrowed books
   get notifications as well
   need to be able to get recently borrowed books -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard - Richfield Online Library</title>
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
            display: flex;
            flex-direction: column;
        }
        
        .dashboard-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
            flex: 1;
            padding-bottom: 2rem;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border: none;
            background: rgba(255, 255, 255, 0.95);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: var(--richfield-blue);
            color: white;
            font-weight: 600;
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
        
        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            padding: 5px 8px;
            border-radius: 50%;
            background-color: var(--richfield-red);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Footer styling */
        footer {
            background-color: rgba(0, 86, 179, 0.9);
            color: var(--richfield-white);
            padding: 20px 0;
            margin-top: auto;
            width: 100%;
        }
        
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .dashboard-container {
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
                    <strong>Welcome: <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?></strong>
                </span>
                <span class="user-info">
                    <i class="fas fa-envelope me-1"></i><?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'user@richfield.ac.za'; ?>
                </span>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <!-- Notification Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge"><?php echo isset($_SESSION['notification_count']) ? $_SESSION['notification_count'] : '0'; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0" style="width: 350px;">
                            <!-- Notification content here -->
                        </ul>
                    </li>
                    
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
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

    <!-- Main Content -->
    <div class="container dashboard-container flex-grow-1">
        <div class="row g-4">
            <!-- Book Issued Card -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-book me-2"></i>Books Issued
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Books Currently Borrowed</h5>
                        <p class="display-5"><?php echo isset($_SESSION['books_borrowed']) ? $_SESSION['books_borrowed'] : '0'; ?></p>
                        <a href="view_issued_book.php" class="btn btn-primary">
                            <i class="fas fa-list me-2"></i>View Issued Books
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Book Search Card -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-search me-2"></i>Book Search
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Find New Books</h5>
                        <p class="card-text">Browse our collection of available books</p>
                        <a href="book_search.php" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Search Books
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Borrowing History Card -->
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <i class="fas fa-history me-2"></i>Borrowing History
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Your Reading History</h5>
                        <p class="card-text">View all books you've borrowed</p>
                        <a href="borrowing_history.php" class="btn btn-primary">
                            <i class="fas fa-history me-2"></i>View History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Richfield Graduate Institute of Technology. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>