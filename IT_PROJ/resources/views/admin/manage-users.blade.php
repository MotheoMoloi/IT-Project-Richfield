@extends('layouts.admin')

@section('title', 'Manage Users - Richfield Online Library')

@push('styles')
    <style>
        :root {
            --richfield-blue: #0056b3;
            --richfield-dark-overlay: rgba(0, 30, 60, 0.6);
        }
        
        body {
            background: linear-gradient(var(--richfield-dark-overlay), var(--richfield-dark-overlay)), 
                        url("https://images.pexels.com/photos/267885/pexels-photo-267885.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
        
        .page-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .search-box {
            border-radius: 20px;
            padding-left: 15px;
        }
        
        .stats-card {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .stats-card .number {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .stats-card .label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }
        
        @media (max-width: 991.98px) {
            .page-container {
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
        }
    </style>
@endpush

@section('content')
<div class="container page-container flex-grow-1">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white"><i class="fas fa-users me-2"></i>User Management</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="stats-card bg-white">
                <div class="number text-primary">{{ $users->count() }}</div>
                <div class="label">Total Users</div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control search-box border-start-0" placeholder="Search by name, email, or user ID...">
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-user-plus me-2"></i>Add New User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i>Library Users</span>
            <span class="badge bg-light text-primary">{{ $users->count() }} records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
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
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->student_number }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->program }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <h4>No Users Found</h4>
                                        <p>No user data is currently available.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div>Showing {{ $users->count() }} of {{ $users->count() }} records</div>
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Add New User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="newFirstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="newFirstName" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="newLastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="newLastName" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="newEmail" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="newEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPhone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="newPhone" required>
                    </div>
                    <div class="mb-3">
                        <label for="newProgram" class="form-label">Academic Program</label>
                        <select class="form-select" id="newProgram" required>
                            <option value="">Select Program</option>
                            <option value="BSc IT">BSc Information Technology</option>
                            <option value="BSc CS">BSc Computer Science</option>
                            <option value="BCom">BCom Accounting</option>
                            <option value="BA">BA Psychology</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Register User</button>
            </div>
        </div>
    </div>
</div>
@endsection