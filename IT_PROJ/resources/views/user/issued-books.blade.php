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
<!-- Marquee Announcement -->
<div class="marquee-container">
    <div class="container">
        <p class="marquee-text">
            <i class="fas fa-info-circle me-2"></i> This is the Richfield Library Management System. Library opens at 8:00 AM and closes at 8:00 PM. Extended hours during exams: 7:00 AM to 10:00 PM.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="container books-container flex-grow-1">
    <!-- Alert Notification -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                    <div>
                        <strong>Due Date Reminder:</strong> 
                        @if(isset($overdueCount) && $overdueCount > 0)
                            You have {{ $overdueCount }} book(s) overdue. Please return them to avoid additional fines.
                        @else
                            You have books due soon. Please return or renew them to avoid late fees.
                        @endif
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body">
                    <h4 class="text-center mb-4">
                        <i class="fas fa-book me-2"></i>Issued Books Details
                    </h4>
                    
                    <div class="table-responsive">
                        <table class="table books-table">
                            <thead>
                                <tr>
                                    <th>Book Cover</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Book ID</th>
                                    <th>Issued Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- ATTENTION HERE: This data should come from the controller -->
                                @if(isset($issuedBooks) && count($issuedBooks) > 0)
                                    @foreach($issuedBooks as $issue)
                                    <tr>
                                        <td class="text-center"><i class="fas fa-book fa-2x text-primary"></i></td>
                                        <td>{{ $issue->book->book_name ?? 'N/A' }}</td>
                                        <td>{{ $issue->book->book_author ?? 'N/A' }}</td>
                                        <td>{{ $issue->book->isbn ?? 'N/A' }}</td>
                                        <td>{{ $issue->issue_date->format('d M Y') }}</td>
                                        <td class="{{ $issue->status === 'overdue' ? 'due-soon' : ($issue->due_date->diffInDays(now()) <= 2 ? 'due-later' : '') }}">
                                            {{ $issue->due_date->format('d M Y') }}
                                        </td>
                                        <td>
                                            @if($issue->status === 'issued')
                                                @if($issue->due_date->isPast())
                                                    <span class="badge bg-danger">Overdue</span>
                                                @elseif($issue->due_date->diffInDays(now()) <= 2)
                                                    <span class="badge bg-warning text-dark">Due Soon</span>
                                                @else
                                                    <span class="badge bg-info">Issued</span>
                                                @endif
                                            @elseif($issue->status === 'returned')
                                                <span class="badge bg-success">Returned</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($issue->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($issue->status === 'issued')
                                                @if($issue->canRenew())
                                                    <form action="{{ route('user.books.renew', $issue->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-primary me-1">
                                                            <i class="fas fa-sync-alt me-1"></i>Renew
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('user.books.return', $issue->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-undo me-1"></i>Return
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                                    <i class="fas fa-check me-1"></i>Completed
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <!-- Sample data for demonstration -->
                                    <tr>
                                        <td class="text-center"><i class="fas fa-book fa-2x text-primary"></i></td>
                                        <td>Database System Concepts</td>
                                        <td>Abraham Silberschatz</td>
                                        <td>LIB-2023-001</td>
                                        <td>15 Oct 2023</td>
                                        <td class="due-soon">30 Oct 2023</td>
                                        <td><span class="badge bg-warning text-dark">Due Tomorrow</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-1">
                                                <i class="fas fa-sync-alt me-1"></i>Renew
                                            </button>
                                            <button class="btn btn-sm btn-success">
                                                <i class="fas fa-undo me-1"></i>Return
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-center"><i class="fas fa-book fa-2x text-primary"></i></td>
                                        <td>Introduction to Algorithms</td>
                                        <td>Thomas H. Cormen</td>
                                        <td>LIB-2023-045</td>
                                        <td>20 Oct 2023</td>
                                        <td class="due-later">05 Nov 2023</td>
                                        <td><span class="badge bg-info">Due in 6 days</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-1">
                                                <i class="fas fa-sync-alt me-1"></i>Renew
                                            </button>
                                            <button class="btn btn-sm btn-success">
                                                <i class="fas fa-undo me-1"></i>Return
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="text-center"><i class="fas fa-book fa-2x text-primary"></i></td>
                                        <td>Clean Code</td>
                                        <td>Robert C. Martin</td>
                                        <td>LIB-2023-112</td>
                                        <td>01 Oct 2023</td>
                                        <td class="returned">15 Oct 2023</td>
                                        <td><span class="badge bg-success">Returned</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                                <i class="fas fa-check me-1"></i>Completed
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <!-- ATTENTION HERE: Route needs to be defined -->
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fas fa-history me-1"></i>View Borrowing History
                            </a>
                        </div>
                        <div>
                            <!-- ATTENTION HERE: Route needs to be defined -->
                            <a href="#" class="btn btn-primary-custom btn-primary">
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

        // Renew book confirmation
        const renewButtons = document.querySelectorAll('button.btn-primary');
        renewButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (this.innerHTML.includes('fa-sync-alt')) {
                    if (!confirm('Are you sure you want to renew this book?')) {
                        e.preventDefault();
                    }
                }
            });
        });

        // Return book confirmation
        const returnButtons = document.querySelectorAll('button.btn-success');
        returnButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (this.innerHTML.includes('fa-undo')) {
                    if (!confirm('Are you sure you want to return this book?')) {
                        e.preventDefault();
                    }
                }
            });
        });
    });
</script>
@endpush