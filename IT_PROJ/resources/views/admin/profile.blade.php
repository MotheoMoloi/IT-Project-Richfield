@extends('layouts.admin')

@section('title', 'Admin Profile - Richfield Online Library')

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
    
    .profile-header {
        color: var(--richfield-blue);
        margin-bottom: 30px;
        position: relative;
        text-align: center;
    }
    
    .profile-header:after {
        content: "";
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background-color: var(--richfield-blue);
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid var(--richfield-light-blue);
        margin: 0 auto 20px;
        display: block;
    }
    
    .profile-detail {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .profile-detail-label {
        font-weight: 600;
        color: var(--richfield-blue);
        margin-bottom: 5px;
    }
    
    .profile-detail-value {
        font-size: 1.1rem;
    }
    
    .placeholder-text {
        color: #6c757d;
        font-style: italic;
    }
    
    /* Loading animation */
    .loading {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 4px;
        min-height: 20px;
        display: inline-block;
        width: 80%;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endpush

@section('content')
<!-- Marquee Announcement -->
<div class="marquee-container">
    <div class="container">
        <p class="marquee-text">
            <i class="fas fa-info-circle me-2"></i> Library hours: Mon-Fri 8AM-8PM, Sat 9AM-5PM. Extended hours during exams: 7AM-10PM daily.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container profile-container flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-custom card">
                <div class="card-body p-4 p-md-5">
                    <h3 class="profile-header">
                        <i class="fas fa-user-shield me-2"></i>Admin Profile
                    </h3>
                    
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <img id="admin-avatar" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="Profile Picture" class="profile-avatar">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <div class="profile-detail-label">Full Name</div>
                                <div class="profile-detail-value">
                                    @if($admin->name)
                                        {{ $admin->name }}
                                    @else
                                        <span class="placeholder-text">Not provided</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="profile-detail">
                                <div class="profile-detail-label">Admin ID</div>
                                <div class="profile-detail-value">
                                    #{{ $admin->id }}
                                </div>
                            </div>
                            
                            <div class="profile-detail">
                                <div class="profile-detail-label">Email Address</div>
                                <div class="profile-detail-value">
                                    {{ $admin->email }}
                                </div>
                            </div>
                            
                            <div class="profile-detail">
                                <div class="profile-detail-label">Mobile Number</div>
                                <div class="profile-detail-value">
                                    @if($admin->mobile)
                                        {{ $admin->mobile }}
                                    @else
                                        <span class="placeholder-text">Not provided</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="profile-detail">
                                <div class="profile-detail-label">Position</div>
                                <div class="profile-detail-value">
                                    @if($admin->position)
                                        {{ $admin->position }}
                                    @else
                                        <span class="placeholder-text">Not specified</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="profile-detail">
                                <div class="profile-detail-label">Department</div>
                                <div class="profile-detail-value">
                                    @if($admin->department)
                                        {{ $admin->department }}
                                    @else
                                        <span class="placeholder-text">Not specified</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="profile-detail">
                                <div class="profile-detail-label">Admin Since</div>
                                <div class="profile-detail-value">
                                    {{ $admin->created_at->format('F d, Y') }}
                                </div>
                            </div>
                            
                            <div class="profile-detail mt-4">
                                <div class="profile-detail-label">Office Location</div>
                                <div class="profile-detail-value">
                                    @if($admin->office)
                                        {{ $admin->office }}
                                    @else
                                        <span class="placeholder-text">Not specified</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="profile-detail">
                        <div class="profile-detail-label">Address</div>
                        <div class="profile-detail-value">
                            @if($admin->address)
                                {{ $admin->address }}
                            @else
                                <span class="placeholder-text">Not provided</span>
                            @endif
                        </div>
                    </div>
                        
                    <div class="text-center mt-5">
                        <!-- Motheo change this - Update route to admin profile edit -->
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary-custom btn-primary me-3">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                        <!-- Motheo change this - Update route to password change -->
                        <a href="{{ route('password.change') }}" class="btn btn-outline-primary">
                            <i class="fas fa-key me-2"></i>Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Admin profile loaded for: {{ $admin->name }}');
        
        // Auto-dismiss alerts after 5 seconds
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }
    });
</script>
@endpush