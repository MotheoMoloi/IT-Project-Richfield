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
                        <div class="col-md-8">
                            <form class="profile-form">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control-custom form-control" id="name" value="{{ $user->name ?? '' }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="text" class="form-control-custom form-control" id="email" value="{{ $user->email ?? '' }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="studentId" class="form-label">Student ID</label>
                                    <input type="text" class="form-control-custom form-control" id="studentId" value="{{ $user->student_number ?? '' }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control-custom form-control" id="mobile" value="{{ $user->mobile ?? '' }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Residential Address</label>
                                    <textarea class="form-control-custom form-control" id="address" rows="3" disabled>{{ $user->address ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="program" class="form-label">Academic Program</label>
                                    <!-- MOTHEO - this field might need to be added to the User model ngl -->
                                    <input type="text" class="form-control-custom form-control" id="program" value="{{ $user->program ?? 'Not specified' }}" disabled>
                                </div>
                                <div class="text-center mt-4">
                                    <a href="{{ route('user.profile.edit') }}" class="btn btn-primary-custom btn-primary px-4">
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
@endsection