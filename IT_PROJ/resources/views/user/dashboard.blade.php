@extends('layouts.user')

@section('title', 'User Dashboard - Richfield Online Library')

@push('styles')
<style>
    .dashboard-container {
        margin-top: 2rem;
        margin-bottom: 2rem;
        flex: 1;
        padding-bottom: 2rem;
    }
    
    .card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
    
    .card-header {
        background-color: var(--richfield-blue);
        color: white;
        font-weight: 600;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--richfield-blue);
    }
    
    .alert-warning {
        border-left: 4px solid #ffc107;
    }
    
    .alert-danger {
        border-left: 4px solid #dc3545;
    }
</style>
@endpush

@section('content')
<div class="container dashboard-container">
    <!-- Welcome Message -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    <h4 class="mb-0">Welcome back, {{ $user->name }}!</h4>
                    <p class="text-muted mb-0">Here's your library overview</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if($overdueBooks > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                    <div>
                        <strong>Overdue Books Alert:</strong> 
                        You have {{ $overdueBooks }} book(s) overdue. Please return them immediately to avoid additional fines.
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Books Issued Card -->
        <div class="col-md-4">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-book me-2"></i>Books Issued
                </div>
                <div class="card-body text-center">
                    <div class="stat-number">{{ $booksBorrowed }}</div>
                    <p class="card-text">Books Currently Borrowed</p>
                    <a href="{{ route('user.issued-books') }}" class="btn btn-primary-custom btn-primary">
                        <i class="fas fa-list me-2"></i>View Issued Books
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Book Search Card -->
        <div class="col-md-4">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-search me-2"></i>Book Search
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Find New Books</h5>
                    <p class="card-text">Browse our collection of available books</p>
                    <a href="{{ route('user.books.browse') }}" class="btn btn-primary-custom btn-primary">
                        <i class="fas fa-search me-2"></i>Browse Books
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Borrowing History Card -->
        <div class="col-md-4">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i>Borrowing History
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Your Reading History</h5>
                    <p class="card-text">View all books you've borrowed</p>
                    <a href="{{ route('user.borrowing.history') }}" class="btn btn-primary-custom btn-primary">
                        <i class="fas fa-history me-2"></i>View History
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Borrows -->
    @if($recentBorrows->count() > 0)
    <div class="row g-4">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-header">
                    <i class="fas fa-clock me-2"></i>Recent Borrows
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Author</th>
                                    <th>Issued Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBorrows as $borrow)
                                <tr>
                                    <td>{{ $borrow->book->book_name }}</td>
                                    <td>{{ $borrow->book->book_author }}</td>
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
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
@endpush