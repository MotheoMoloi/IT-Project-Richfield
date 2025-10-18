@extends('layouts.app')

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('user.dashboard') }}">
            <i class="fas fa-book-open me-2"></i>Richfield Library
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <span class="user-info me-auto">
                <strong>Welcome: {{ Auth::user()->name ?? 'User' }}</strong>
            </span>
            <span class="user-info">
                <i class="fas fa-envelope me-1"></i>{{ Auth::user()->email ?? 'user@richfield.ac.za' }}
            </span>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <!-- Notification Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">{{ session('notification_count', 0) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-0" style="width: 350px;">
                        <!-- Notification content would go here -->
                    </ul>
                </li>
                
                <!-- Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>My Profile
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user me-2"></i>View Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('user.profile.edit') }}"><i class="fas fa-edit me-2"></i>Edit Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('password.change') }}"><i class="fas fa-key me-2"></i>Change Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endsection

@section('footer')
<footer>
    <div class="container text-center">
        <p class="mb-0">&copy; {{ date('Y') }} Richfield Graduate Institute of Technology. All rights reserved.</p>
    </div>
</footer>
@endsection