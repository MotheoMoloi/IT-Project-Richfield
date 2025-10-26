@extends('layouts.admin')

@section('title', 'Overdue Books - Richfield Online Library')

@push('styles')
<style>
    .overdue-container {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    
    .table th {
        background-color: #dc3545;
        color: white;
    }
    
    .overdue-row {
        background-color: #fff5f5;
    }
    
    .critical-overdue {
        background-color: #ffe6e6;
        border-left: 4px solid #dc3545;
    }
    
    .fine-amount {
        color: #dc3545;
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .days-overdue {
        font-weight: bold;
    }
    
    .stats-card {
        text-align: center;
    }
    
    .stats-number {
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    
    .action-btns {
        white-space: nowrap;
    }
    
    .total-fines-card {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container overdue-container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Overdue Books</h4>
                            <p class="text-muted mb-0">Books that are past their due date</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.borrows.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Back to All Borrows
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
                    <div class="stats-number text-danger">{{ $totalOverdue }}</div>
                    <p class="card-text">Total Overdue Books</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom card stats-card">
                <div class="card-body">
                    <div class="stats-number text-warning">{{ $criticalOverdue }}</div>
                    <p class="card-text">Over 7 Days Late</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom card stats-card">
                <div class="card-body">
                    <div class="stats-number text-info">{{ $studentsWithOverdue }}</div>
                    <p class="card-text">Students Affected</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom card stats-card total-fines-card">
                <div class="card-body">
                    <div class="stats-number">R{{ number_format($totalPotentialFines, 2) }}</div>
                    <p class="card-text mb-0">Potential Fines</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Overdue Books Table -->
    <div class="row">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    @if($overdueBooks->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Book Details</th>
                                    <th>Contact Info</th>
                                    <th>Due Date</th>
                                    <th>Days Overdue</th>
                                    <th>Potential Fine</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($overdueBooks as $borrow)
                                @php
                                    $daysOverdue = now()->diffInDays($borrow->due_date);
                                    $isCritical = $daysOverdue > 7;
                                    $potentialFine = $daysOverdue * 5; // R5 per day
                                    $rowClass = $isCritical ? 'critical-overdue' : 'overdue-row';
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td>
                                        <strong>{{ $borrow->user->name }}</strong><br>
                                        <small class="text-muted">{{ $borrow->user->student_number }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $borrow->book->book_name }}</strong><br>
                                        <small class="text-muted">{{ $borrow->book->book_author }}</small><br>
                                        <small class="text-muted">ISBN: {{ $borrow->book->isbn }}</small>
                                    </td>
                                    <td>
                                        <small>{{ $borrow->user->email }}</small><br>
                                        <small>{{ $borrow->user->mobile ?? 'No phone' }}</small>
                                    </td>
                                    <td class="text-danger fw-bold">
                                        {{ $borrow->due_date->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <span class="days-overdue text-danger">{{ $daysOverdue }} days</span>
                                        @if($isCritical)
                                        <br><small class="text-danger">⚠️ Critical</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fine-amount">R{{ number_format($potentialFine, 2) }}</span>
                                    </td>
                                    <td class="action-btns">
                                        <form action="{{ route('admin.borrows.return', $borrow->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Mark this book as returned? Fine: R{{ number_format($potentialFine, 2) }}')">
                                                <i class="fas fa-check me-1"></i>Return
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-outline-warning" 
                                                onclick="alert('Send reminder to: {{ $borrow->user->email }}')">
                                            <i class="fas fa-envelope me-1"></i>Remind
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $overdueBooks->firstItem() }} to {{ $overdueBooks->lastItem() }} 
                            of {{ $overdueBooks->total() }} overdue books
                        </div>
                        <div>
                            {{ $overdueBooks->links() }}
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h4 class="text-success">No Overdue Books!</h4>
                        <p class="text-muted">All books have been returned on time.</p>
                        <a href="{{ route('admin.borrows.index') }}" class="btn btn-primary-custom btn-primary">
                            <i class="fas fa-list me-2"></i>View All Borrows
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($overdueBooks->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body text-center">
                    <h5 class="mb-3">Bulk Actions</h5>
                    <button class="btn btn-outline-warning me-2" onclick="alert('This would send reminders to all students with overdue books')">
                        <i class="fas fa-envelope me-2"></i>Send Reminders to All
                    </button>
                    <button class="btn btn-outline-info" onclick="alert('This would generate a report of all overdue books')">
                        <i class="fas fa-file-pdf me-2"></i>Generate Overdue Report
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')


@endpush