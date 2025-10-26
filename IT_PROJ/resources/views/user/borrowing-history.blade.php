@extends('layouts.user')

@section('title', 'Borrowing History - Richfield Online Library')

@push('styles')
<style>
    .history-container {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    
    .table th {
        background-color: var(--richfield-blue);
        color: white;
    }
    
    .status-badge {
        font-size: 0.8rem;
    }
    
    .returned-badge {
        background-color: #28a745;
    }
    
    .overdue-badge {
        background-color: #dc3545;
    }
    
    .issued-badge {
        background-color: #17a2b8;
    }
    
    .renewed-badge {
        background-color: #ffc107;
        color: #000;
    }
    
    .fine-amount {
        color: #dc3545;
        font-weight: bold;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }
</style>
@endpush

@section('content')
<div class="container history-container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><i class="fas fa-history me-2"></i>Borrowing History</h4>
                            <p class="text-muted mb-0">Your complete library borrowing record</p>
                        </div>
                        <div>
                            <a href="{{ route('user.issued-books') }}" class="btn btn-outline-primary">
                                <i class="fas fa-book me-2"></i>Current Borrows
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card-custom card text-center">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $borrowingHistory->total() }}</h5>
                    <p class="card-text">Total Books Borrowed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom card text-center">
                <div class="card-body">
                    <h5 class="card-title text-success">{{ $returnedCount }}</h5>
                    <p class="card-text">Books Returned</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom card text-center">
                <div class="card-body">
                    <h5 class="card-title text-warning">{{ $renewedCount }}</h5>
                    <p class="card-text">Times Renewed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom card text-center">
                <div class="card-body">
                    <h5 class="card-title text-danger">R{{ number_format($totalFines, 2) }}</h5>
                    <p class="card-text">Total Fines Paid</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowing History Table -->
    <div class="row">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    @if($borrowingHistory->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Book Details</th>
                                    <th>Issue Date</th>
                                    <th>Due Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Fine</th>
                                    <th>Renewals</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowingHistory as $borrow)
                                <tr>
                                    <td>
                                        <strong>{{ $borrow->book->book_name }}</strong><br>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>{{ $borrow->book->book_author }}
                                        </small><br>
                                        <small class="text-muted">
                                            <i class="fas fa-barcode me-1"></i>{{ $borrow->book->isbn }}
                                        </small>
                                    </td>
                                    <td>{{ $borrow->issue_date->format('M d, Y') }}</td>
                                    <td class="{{ $borrow->due_date->isPast() && $borrow->status !== 'returned' ? 'text-danger' : '' }}">
                                        {{ $borrow->due_date->format('M d, Y') }}
                                    </td>
                                    <td>
                                        @if($borrow->return_date)
                                            {{ $borrow->return_date->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($borrow->status === 'returned')
                                            <span class="badge returned-badge status-badge">Returned</span>
                                        @elseif($borrow->status === 'overdue')
                                            <span class="badge overdue-badge status-badge">Overdue</span>
                                        @elseif($borrow->status === 'renewed')
                                            <span class="badge renewed-badge status-badge">Renewed</span>
                                        @else
                                            <span class="badge issued-badge status-badge">Issued</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($borrow->fine_amount > 0)
                                            <span class="fine-amount">R{{ number_format($borrow->fine_amount, 2) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $borrow->renewal_count }} time(s)
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $borrowingHistory->firstItem() }} to {{ $borrowingHistory->lastItem() }} 
                            of {{ $borrowingHistory->total() }} records
                        </div>
                        <div>
                            {{ $borrowingHistory->links() }}
                        </div>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-history fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Borrowing History</h4>
                        <p class="text-muted">You haven't borrowed any books from the library yet.</p>
                        <a href="{{ route('user.books.browse') }}" class="btn btn-primary-custom btn-primary">
                            <i class="fas fa-book-open me-2"></i>Browse Books
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection