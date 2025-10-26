@extends('layouts.admin')

@section('title', 'Manage Borrows - Richfield Online Library')

@push('styles')
<style>
    .borrows-container {
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
    
    .overdue-row {
        background-color: #fff5f5;
    }
    
    .due-soon-row {
        background-color: #fffbf0;
    }
    
    .action-btns {
        white-space: nowrap;
    }
    
    .filter-badge {
        cursor: pointer;
    }
    
    .stats-card {
        text-align: center;
    }
    
    .stats-number {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container borrows-container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><i class="fas fa-list me-2"></i>Manage Borrowed Books</h4>
                            <p class="text-muted mb-0">Track all books currently borrowed by students</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.borrows.overdue') }}" class="btn btn-outline-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>View Overdue
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
            <div class="card-custom card stats-card">
                <div class="card-body">
                    <div class="stats-number text-primary">{{ $totalBorrows }}</div>
                    <p class="card-text">Total Active Borrows</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom card stats-card">
                <div class="card-body">
                    <div class="stats-number text-warning">{{ $dueSoonCount }}</div>
                    <p class="card-text">Due in 3 Days</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom card stats-card">
                <div class="card-body">
                    <div class="stats-number text-danger">{{ $overdueCount }}</div>
                    <p class="card-text">Overdue Books</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom card stats-card">
                <div class="card-body">
                    <div class="stats-number text-success">{{ $renewedCount }}</div>
                    <p class="card-text">Renewed Books</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <strong>Filter by Status:</strong>
                        <a href="{{ request()->fullUrlWithQuery(['status' => '']) }}" 
                           class="badge bg-secondary filter-badge {{ !request('status') ? 'bg-primary' : '' }}">
                            All ({{ $totalBorrows }})
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'issued']) }}" 
                           class="badge bg-info filter-badge {{ request('status') == 'issued' ? 'bg-primary' : '' }}">
                            Issued ({{ $issuedCount }})
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'renewed']) }}" 
                           class="badge bg-warning filter-badge {{ request('status') == 'renewed' ? 'bg-primary' : '' }}">
                            Renewed ({{ $renewedCount }})
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'overdue']) }}" 
                           class="badge bg-danger filter-badge {{ request('status') == 'overdue' ? 'bg-primary' : '' }}">
                            Overdue ({{ $overdueCount }})
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrows Table -->
    <div class="row">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    @if($borrows->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Book Details</th>
                                    <th>Issue Date</th>
                                    <th>Due Date</th>
                                    <th>Days Left</th>
                                    <th>Status</th>
                                    <th>Renewals</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrows as $borrow)
                                @php
                                    $daysLeft = now()->diffInDays($borrow->due_date, false);
                                    $isOverdue = $daysLeft < 0;
                                    $isDueSoon = $daysLeft >= 0 && $daysLeft <= 3;
                                    $rowClass = $isOverdue ? 'overdue-row' : ($isDueSoon ? 'due-soon-row' : '');
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td>
                                        <strong>{{ $borrow->user->name }}</strong><br>
                                        <small class="text-muted">{{ $borrow->user->student_number }}</small><br>
                                        <small class="text-muted">{{ $borrow->user->email }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $borrow->book->book_name }}</strong><br>
                                        <small class="text-muted">{{ $borrow->book->book_author }}</small><br>
                                        <small class="text-muted">ISBN: {{ $borrow->book->isbn }}</small>
                                    </td>
                                    <td>{{ $borrow->issue_date->format('M d, Y') }}</td>
                                    <td class="{{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                                        {{ $borrow->due_date->format('M d, Y') }}
                                    </td>
                                    <td class="{{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                                        @if($isOverdue)
                                            Overdue by {{ abs($daysLeft) }} days
                                        @else
                                            {{ $daysLeft }} days
                                        @endif
                                    </td>
                                    <td>
                                        @if($isOverdue)
                                            <span class="badge bg-danger status-badge">Overdue</span>
                                        @elseif($isDueSoon)
                                            <span class="badge bg-warning status-badge">Due Soon</span>
                                        @elseif($borrow->status === 'renewed')
                                            <span class="badge bg-info status-badge">Renewed</span>
                                        @else
                                            <span class="badge bg-success status-badge">Issued</span>
                                        @endif
                                    </td>
                                    <td>{{ $borrow->renewal_count }}</td>
                                    <td class="action-btns">
                                        <form action="{{ route('admin.borrows.return', $borrow->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Mark this book as returned?')">
                                                <i class="fas fa-check me-1"></i>Return
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $borrows->firstItem() }} to {{ $borrows->lastItem() }} 
                            of {{ $borrows->total() }} records
                        </div>
                        <div>
                            {{ $borrows->links() }}
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Active Borrows</h4>
                        <p class="text-muted">There are no books currently borrowed from the library.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush