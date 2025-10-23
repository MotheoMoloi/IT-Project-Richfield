@extends('layouts.app')

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('login') }}">
            <i class="fas fa-book-open me-2"></i>Richfield Online Library
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i> Student Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.login.form') ? 'active' : '' }}" href="{{ route('admin.login.form') }}">
                        <i class="fas fa-user-shield me-1"></i> Admin Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('register.form') ? 'active' : '' }}" href="{{ route('register.form') }}">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
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