@extends('layouts.user')

@section('title', 'Student Profile - Richfield Online Library')

@push('styles')
<style>
    .profile-container {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    
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
    
    .profile-field {
        margin-bottom: 1.5rem;
    }
    
    .profile-label {
        font-weight: 600;
        color: var(--richfield-blue);
        margin-bottom: 0.5rem;
    }
    
    .profile-value {
        padding: 0.75rem;
        background-color: #f8f9fa;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }
</style>
@endpush

@section('content')
<!-- Marquee Announcement -->
<div class="marquee-container">
    <div class="container">
        <p class="marquee-text">
            <i class="fas fa-info-circle me-2"></i>
            Profile information is retrieved from your student records.
        </p>
    </div>
</div>

<div class="container profile-container flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-custom card">
                <div class="card-body">
                    <h4 class="profile-header text-center mb-4">
                        <i class="fas fa-user-graduate me-2"></i>Student Profile Details
                    </h4>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="profile-form">
                                <!-- Success Message -->
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="profile-field">
                                            <div class="profile-label">Full Name</div>
                                            <div class="profile-value">{{ $user->name ?? 'Not provided' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="profile-field">
                                            <div class="profile-label">Email Address</div>
                                            <div class="profile-value">{{ $user->email ?? 'Not provided' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="profile-field">
                                            <div class="profile-label">Student Number</div>
                                            <div class="profile-value">{{ $user->student_number ?? 'Not provided' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="profile-field">
                                            <div class="profile-label">Academic Program</div>
                                            <div class="profile-value">{{ $user->program ?? 'Not specified' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="profile-field">
                                            <div class="profile-label">Mobile Number</div>
                                            <div class="profile-value">{{ $user->mobile ?? 'Not provided' }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="profile-field">
                                            <div class="profile-label">Account Type</div>
                                            <div class="profile-value">Student</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-field">
                                    <div class="profile-label">Residential Address</div>
                                    <div class="profile-value">{{ $user->address ?? 'Not provided' }}</div>
                                </div>

                                <div class="profile-field">
                                    <div class="profile-label">Member Since</div>
                                    <div class="profile-value">{{ $user->created_at->format('F d, Y') }}</div>
                                </div>

                                <div class="text-center mt-4">
                                    <a href="{{ route('user.profile.edit') }}" class="btn btn-primary-custom btn-primary px-4">
                                        <i class="fas fa-edit me-2"></i>Edit Profile
                                    </a>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary px-4 ms-2">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection