<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Richfield Online Library')</title>
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
        
        .container-custom {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border: none;
            background: rgba(255, 255, 255, 0.95);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .navbar-custom {
            background-color: var(--richfield-blue) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
        
        .navbar-brand, .nav-link {
            color: var(--richfield-white) !important;
        }
        
        .nav-link:hover {
            color: var(--richfield-light-blue) !important;
        }
        
        .btn-primary-custom {
            background-color: var(--richfield-blue);
            border-color: var(--richfield-blue);
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .btn-primary-custom:hover {
            background-color: #004494;
            border-color: #004494;
        }
        
        .form-control-custom {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .form-control-custom:focus {
            border-color: var(--richfield-blue);
            box-shadow: 0 0 0 0.25rem rgba(0, 86, 179, 0.25);
            background-color: white;
        }
        
        .welcome-message {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--richfield-blue);
            margin-bottom: 1.5rem;
        }
        
        footer {
            background-color: rgba(0, 86, 179, 0.9);
            color: var(--richfield-white);
            padding: 15px 0;
            margin-top: auto;
        }
        
        .user-info {
            color: white;
            margin-right: 15px;
        }
        
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
        
        @media (max-width: 991.98px) {
            .container-custom {
                margin-top: 1.5rem;
                margin-bottom: 1.5rem;
            }
            
            .welcome-message {
                font-size: 1.5rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    @yield('navbar')
    
    <main class="flex-grow-1">
        @yield('content')
    </main>

    @yield('footer')
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>