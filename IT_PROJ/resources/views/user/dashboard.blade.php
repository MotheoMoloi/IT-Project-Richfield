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
    }
    
    .card-header {
        background-color: var(--richfield-blue);
        color: white;
        font-weight: 600;
    }
    
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        padding: 5px 8px;
        border-radius: 50%;
        background-color: var(--richfield-red);
        color: white;
        font-size: 12px;
        font-weight: bold;
    }
</style>
@endpush

@section('content')
<div class="container dashboard-container">
    <div class="row g-4">
        <!-- Book Issued Card -->
        <div class="col-md-4">
            <div class="card-custom card h-100">
                <div class="card-header">
                    <i class="fas fa-book me-2"></i>Books Issued
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Books Currently Borrowed</h5>
                    <p class="display-5">{{ $booksBorrowed ?? '0' }}</p>
                    <!-- MOTHEO - route needs to be defined -->
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
                    <!-- MOTHEO - route needs to be defined -->
                    <a href="#" class="btn btn-primary-custom btn-primary">
                        <i class="fas fa-search me-2"></i>Search Books
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
                    <!-- MOTHEO - route needs to be defined -->
                    <a href="#" class="btn btn-primary-custom btn-primary">
                        <i class="fas fa-history me-2"></i>View History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection