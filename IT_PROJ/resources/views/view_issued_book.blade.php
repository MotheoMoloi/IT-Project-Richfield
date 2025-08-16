<!DOCTYPE html>
<html lang="en">
<head>
    <title>Issued Books - Richfield Online Library</title>
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
        
        .books-container {
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
        
        /* Books table styling */
        .books-table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .books-table thead {
            background-color: var(--richfield-blue);
            color: white;
        }
        
        .books-table th {
            padding: 15px;
            text-align: center;
        }
        
        .books-table td {
            padding: 12px;
            vertical-align: middle;
        }
        
        .books-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .books-table tr:hover {
            background-color: var(--richfield-light-blue);
        }
        
        .due-soon {
            color: var(--richfield-red);
            font-weight: bold;
        }
        
        .due-later {
            color: #ffc107;
            font-weight: bold;
        }
        
        .returned {
            color: #28a745;
            font-weight: bold;
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
            .books-container {
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
                    <strong>Welcome: John Doe</strong>
                </span>
                <span class="user-info">
                    <i class="fas fa-envelope me-1"></i>john.doe@richfield.ac.za
                </span>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <!-- Notification Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">1</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0" style="width: 350px;">
                            <li class="dropdown-header bg-light py-2 px-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Notifications (1)</strong>
                                    <a href="#" class="small">Mark all as read</a>
                                </div>
                            </li>
                            <div style="max-height: 400px; overflow-y: auto;">
                                <!-- Unread Notification - Book Due Soon -->
                                <li>
                                    <a class="dropdown-item notification-item unread" href="#">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle notification-icon text-warning"></i>
                                            <div>
                                                <div>Your book <strong>"Database Systems"</strong> is due tomorrow</div>
                                                <small class="notification-time">Today, 11:45 AM</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </div>
                            <li class="dropdown-footer bg-light py-2 px-3 text-center">
                                <a href="notifications.php">View all notifications</a>
                            </li>
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

    <!-- Marquee Announcement -->
    <div class="marquee-container">
        <div class="container">
            <p class="marquee-text">
                <i class="fas fa-info-circle me-2"></i> This is the Richfield Library Management System. Library opens at 8:00 AM and closes at 8:00 PM. Extended hours during exams: 7:00 AM to 10:00 PM.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container books-container flex-grow-1">
        <!-- Alert Notification -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div>
                            <strong>Due Date Reminder:</strong> You have 1 book due tomorrow. Please return or renew it to avoid late fees.
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center mb-4">
                            <i class="fas fa-book me-2"></i>Issued Books Details
                        </h4>
                        
                        <div class="table-responsive">
                            <table class="table books-table">
                                <thead>
                                    <tr>
                                        <th>Book Cover</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Book ID</th>
                                        <th>Issued Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Sample Book 1 (Due Soon) -->
                                    <tr>
                                        <td class="text-center"><i class="fas fa-book fa-2x text-primary"></i></td>
                                        <td>Database System Concepts</td>
                                        <td>Abraham Silberschatz</td>
                                        <td>LIB-2023-001</td>
                                        <td>15 Oct 2023</td>
                                        <td class="due-soon">30 Oct 2023</td>
                                        <td><span class="badge bg-warning text-dark">Due Tomorrow</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-1">
                                                <i class="fas fa-sync-alt me-1"></i>Renew
                                            </button>
                                            <button class="btn btn-sm btn-success">
                                                <i class="fas fa-undo me-1"></i>Return
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Sample Book 2 (Due Later) -->
                                    <tr>
                                        <td class="text-center"><i class="fas fa-book fa-2x text-primary"></i></td>
                                        <td>Introduction to Algorithms</td>
                                        <td>Thomas H. Cormen</td>
                                        <td>LIB-2023-045</td>
                                        <td>20 Oct 2023</td>
                                        <td class="due-later">05 Nov 2023</td>
                                        <td><span class="badge bg-info">Due in 6 days</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-1">
                                                <i class="fas fa-sync-alt me-1"></i>Renew
                                            </button>
                                            <button class="btn btn-sm btn-success">
                                                <i class="fas fa-undo me-1"></i>Return
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Sample Book 3 (Returned) -->
                                    <tr>
                                        <td class="text-center"><i class="fas fa-book fa-2x text-primary"></i></td>
                                        <td>Clean Code</td>
                                        <td>Robert C. Martin</td>
                                        <td>LIB-2023-112</td>
                                        <td>01 Oct 2023</td>
                                        <td class="returned">15 Oct 2023</td>
                                        <td><span class="badge bg-success">Returned</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                                <i class="fas fa-check me-1"></i>Completed
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <div>
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-history me-1"></i>View Borrowing History
                                </button>
                            </div>
                            <div>
                                <button class="btn btn-primary">
                                    <i class="fas fa-book-open me-1"></i>Browse More Books
                                </button>
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
            <p class="mb-0">&copy; 2023 Richfield Graduate Institute of Technology. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>