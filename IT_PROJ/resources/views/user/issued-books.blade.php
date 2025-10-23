@extends('layouts.user')

@section('title', 'Issued Books - Richfield Online Library')

@push('styles')
<style>
    .books-container {
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
    
    .books-table {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .books-table thead {
        background-color: var(--richfield-blue);
        color: white;
    }
    
    .books-table th {
        padding: 15px;
        text-align: center;
    }
    
    .books-table td {
        padding: 12px;
        vertical-align: middle;
    }
    
    .books-table tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .books-table tr:hover {
        background-color: var(--richfield-light-blue);
    }
    
    .due-soon {
        color: var(--richfield-red);
        font-weight: bold;
    }
    
    .due-later {
        color: #ffc107;
        font-weight: bold;
    }
    
    .returned {
        color: #28a745;
        font-weight: bold;
    }
    
    .action-btns form {
        display: inline-block;
        margin: 2px;
    }
</style>
@endpush

@section('content')
<!-- Marquee Announcement -->
<div class="marquee-container">
    <div class="container">
        <p class="marquee-text">
            <i class="fas fa-info-circle me-2"></i> 
            This is the Richfield Library Management System. Library opens at 8:00 AM and closes at 8:00 PM. Extended hours during exams: 7:00 AM to 10:00 PM.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container books-container flex-grow-1">
    <!-- Alert Notification -->
    @if($overdueCount > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                    <div>
                        <strong>Due Date Reminder:</strong> 
                        You have {{ $overdueCount }} book(s) overdue. Please return them immediately to avoid additional fines.
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif($issuedBooks->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle me-3 fs-4"></i>
                    <div>
                        <strong>Due Date Reminder:</strong> 
                        You have books due soon. Please return or renew them to avoid late fees.
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
    @endif
    
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-book me-2"></i>Currently Issued Books
                    </h4>
                    
                    @if($issuedBooks->count() > 0)
                    <div class="table-responsive">
                        <table class="table books-table">
                            <thead>
                                <tr>
                                    <th>Book Cover</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>ISBN</th>
                                    <th>Issued Date</th>
                                    <th>Due Date</th>
                                    <th>Days Left</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($issuedBooks as $borrow)
                                @php
                                    $daysLeft = now()->diffInDays($borrow->due_date, false);
                                    $isOverdue = $daysLeft < 0;
                                    $isDueSoon = $daysLeft >= 0 && $daysLeft <= 2;
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        <i class="fas fa-book fa-2x text-primary"></i>
                                    </td>
                                    <td>{{ $borrow->book->book_name }}</td>
                                    <td>{{ $borrow->book->book_author }}</td>
                                    <td>{{ $borrow->book->isbn }}</td>
                                    <td>{{ $borrow->issue_date->format('d M Y') }}</td>
                                    <td class="{{ $isOverdue ? 'due-soon' : ($isDueSoon ? 'due-later' : '') }}">
                                        {{ $borrow->due_date->format('d M Y') }}
                                    </td>
                                    <td class="{{ $isOverdue ? 'due-soon' : ($isDueSoon ? 'due-later' : '') }}">
                                        @if($isOverdue)
                                            Overdue by {{ abs($daysLeft) }} days
                                        @else
                                            {{ $daysLeft }} days
                                        @endif
                                    </td>
                                    <td>
                                        @if($isOverdue)
                                            <span class="badge bg-danger">Overdue</span>
                                        @elseif($isDueSoon)
                                            <span class="badge bg-warning text-dark">Due Soon</span>
                                        @else
                                            <span class="badge bg-info">Issued</span>
                                        @endif
                                    </td>
                                    <td class="action-btns">
                                        @if($borrow->canRenew())
                                        <form action="{{ route('user.books.renew', $borrow->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary" 
                                                    onclick="return confirm('Renew this book for 7 more days?')">
                                                <i class="fas fa-sync-alt me-1"></i>Renew
                                            </button>
                                        </form>
                                        @endif
                                        
                                        <form action="{{ route('user.books.return', $borrow->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Are you sure you want to return this book?')">
                                                <i class="fas fa-undo me-1"></i>Return
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No books currently issued</h5>
                        <p class="text-muted">You haven't borrowed any books yet.</p>
                        <a href="{{ route('user.books.browse') }}" class="btn btn-primary-custom btn-primary">
                            <i class="fas fa-book-open me-2"></i>Browse Books
                        </a>
                    </div>
                    @endif
                    
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('user.borrowing.history') }}" class="btn btn-outline-primary">
                                <i class="fas fa-history me-1"></i>View Borrowing History
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('user.books.browse') }}" class="btn btn-primary-custom btn-primary">
                                <i class="fas fa-book-open me-1"></i>Browse More Books
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alert after 5 seconds
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }

        // Add confirmation for all forms
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to proceed?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush