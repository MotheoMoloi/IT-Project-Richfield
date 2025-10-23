@extends('layouts.admin')

@section('title', 'Admin Dashboard - Richfield Online Library')

@push('styles')
<style>
    .dashboard-container {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        text-align: center;
        padding: 20px 0;
    }
    
    .stat-card .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: var(--richfield-blue);
    }
    
    .stat-card .stat-number {
        font-size: 2.2rem;
        font-weight: bold;
        margin-bottom: 5px;
        color: var(--richfield-blue);
    }
    
    .stat-card .stat-label {
        font-size: 1rem;
        color: #6c757d;
    }
    
    .quick-actions .btn {
        margin: 5px;
    }
</style>
@endpush

@section('content')
<div class="container dashboard-container flex-grow-1">
    <!-- Stats Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Registered Users Card -->
        <div class="col-md-3">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-users me-2"></i>Registered Users
                </div>
                <div class="card-body stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $userCount }}</div>
                    <div class="stat-label">Active Library Users</div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary-custom btn-primary mt-3">
                        <i class="fas fa-user-cog me-2"></i>Manage Users
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Total Books Card -->
        <div class="col-md-3">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-book me-2"></i>Total Books
                </div>
                <div class="card-body stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-number">{{ $bookCount }}</div>
                    <div class="stat-label">Books in Collection</div>
                    <a href="{{ route('admin.books.manage') }}" class="btn btn-primary-custom btn-primary mt-3">
                        <i class="fas fa-book-open me-2"></i>Manage Books
                    </a>
                </div>
            </div>
        </div>

        <!-- Books Issued Card -->
        <div class="col-md-3">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-book-reader me-2"></i>Books Issued
                </div>
                <div class="card-body stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <div class="stat-number">{{ $issuedBookCount }}</div>
                    <div class="stat-label">Currently Checked Out</div>
                    <a href="{{ route('admin.borrows.index') }}" class="btn btn-primary-custom btn-primary mt-3">
                        <i class="fas fa-list me-2"></i>View All
                    </a>
                </div>
            </div>
        </div>

        <!-- Overdue Books Card -->
        <div class="col-md-3">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-exclamation-triangle me-2"></i>Overdue Books
                </div>
                <div class="card-body stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                    <div class="stat-number text-danger">{{ $overdueCount }}</div>
                    <div class="stat-label">Books Overdue</div>
                    <a href="{{ route('admin.borrows.overdue') }}" class="btn btn-outline-danger mt-3">
                        <i class="fas fa-clock me-2"></i>View Overdue
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity and Quick Actions -->
    <div class="row g-4">
        <!-- Recent Borrows -->
        <div class="col-md-8">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i>Recent Borrowing Activity
                </div>
                <div class="card-body">
                    @if($recentBorrows->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Book</th>
                                    <th>Issued Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBorrows as $borrow)
                                <tr>
                                    <td>{{ $borrow->user->name }}</td>
                                    <td>{{ $borrow->book->book_name }}</td>
                                    <td>{{ $borrow->issue_date->format('M d, Y') }}</td>
                                    <td class="{{ $borrow->due_date->isPast() ? 'text-danger fw-bold' : '' }}">
                                        {{ $borrow->due_date->format('M d, Y') }}
                                    </td>
                                    <td>
                                        @if($borrow->due_date->isPast())
                                        <span class="badge bg-danger">Overdue</span>
                                        @else
                                        <span class="badge bg-success">Issued</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted text-center">No recent borrowing activity.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-4">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </div>
                <div class="card-body text-center quick-actions">
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary-custom btn-primary btn-lg w-100 mb-2">
                        <i class="fas fa-plus-circle me-2"></i>Add New Book
                    </a>
                    <a href="{{ route('admin.books.manage') }}" class="btn btn-outline-primary btn-lg w-100 mb-2">
                        <i class="fas fa-book-open me-2"></i>Manage Books
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary btn-lg w-100 mb-2">
                        <i class="fas fa-users me-2"></i>Manage Users
                    </a>
                    <a href="{{ route('admin.borrows.index') }}" class="btn btn-outline-primary btn-lg w-100">
                        <i class="fas fa-list me-2"></i>View All Borrows
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection