@extends('layouts.admin')

@section('title', 'Manage Users - Richfield Online Library')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">
            <i class="fas fa-users me-2"></i>Manage Users
        </h1>
    </div>

    <!-- Table Section -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Student Number</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Program</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- The user data will go here still busy -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection