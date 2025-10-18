@extends('layouts.user')

@section('title', 'Edit Profile - Richfield Online Library')

@section('content')
<div class="container container-custom flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-custom card">
                <div class="card-body p-4 p-md-5">
                    <div class="profile-header">
                        <h3 class="card-title"><i class="fas fa-user-edit text-primary me-2"></i>Edit Profile</h3>
                        <p class="text-muted">Update your personal information</p>
                    </div>

                    <!-- ATTENTION HERE: Form action needs to be updated -->
                    <form action="{{ route('user.profile.update') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label"><i class="fas fa-user text-primary me-2"></i>Full Name</label>
                                    <input type="text" class="form-control-custom form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label"><i class="fas fa-envelope text-primary me-2"></i>Email Address</label>
                                    <input type="email" class="form-control-custom form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mobile" class="form-label"><i class="fas fa-mobile-alt text-primary me-2"></i>Mobile Number</label>
                                    <input type="tel" class="form-control-custom form-control" id="mobile" name="mobile" value="{{ old('mobile', $user->mobile ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label"><i class="fas fa-home text-primary me-2"></i>Address</label>
                            <textarea class="form-control-custom form-control" id="address" name="address" rows="3">{{ old('address', $user->address ?? '') }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" name="update" class="btn btn-primary-custom btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection