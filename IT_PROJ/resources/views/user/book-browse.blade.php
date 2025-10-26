@extends('layouts.user')

@section('title', 'Browse Books - Richfield Online Library')

@push('styles')
<style>
    .books-container {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }
    
    .search-box {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .book-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }
    
    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .book-cover {
        height: 200px;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea 0%, #0056b3 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }
    
    .book-status-available {
        border-left: 4px solid #28a745;
    }
    
    .book-status-checked_out {
        border-left: 4px solid #ffc107;
    }
    
    .category-badge {
        background-color: var(--richfield-blue);
        color: white;
    }
    
    .pagination-container {
        margin-top: 2rem;
    }
</style>
@endpush

@section('content')
<div class="container books-container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-body text-center">
                    <h2><i class="fas fa-book-open me-2"></i>Browse Our Collection</h2>
                    <p class="text-muted mb-0">Discover books available for borrowing</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="search-box">
                <form action="{{ route('user.books.search') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" 
                                       placeholder="Search by title, author, ISBN, or category..." 
                                       value="{{ request('query') }}">
                                <button class="btn btn-primary-custom btn-primary" type="submit">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" name="category" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" 
                                        {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="row g-4">
        @forelse($books as $book)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card-custom card book-card book-status-{{ $book->status }}">
                <div class="book-cover">
                    <i class="fas fa-book"></i>
                </div>
                <div class="card-body">
                    <h6 class="card-title">{{ Str::limit($book->book_name, 50) }}</h6>
                    <p class="card-text text-muted small mb-2">
                        <i class="fas fa-user me-1"></i>{{ $book->book_author }}
                    </p>
                    
                    @if($book->category)
                    <span class="badge category-badge mb-2">{{ $book->category }}</span>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>{{ $book->year }}
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-barcode me-1"></i>{{ $book->isbn }}
                        </small>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-{{ $book->status === 'available' ? 'success' : 'warning' }}">
                            {{ ucfirst($book->status) }}
                        </span>
                        
                        @if($book->status === 'available')
                        <form action="{{ route('user.books.borrow', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary-custom btn-primary" 
                                    onclick="return confirm('Borrow this book?')">
                                <i class="fas fa-plus me-1"></i>Borrow
                            </button>
                        </form>
                        @else
                        <button class="btn btn-sm btn-outline-secondary" disabled>
                            Not Available
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card-custom card text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No Books Found</h4>
                <p class="text-muted">No books match your search criteria.</p>
                <a href="{{ route('user.books.browse') }}" class="btn btn-primary-custom btn-primary">
                    <i class="fas fa-redo me-2"></i>Reset Search
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($books->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="pagination-container text-center">
                {{ $books->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation for borrow actions
        const borrowForms = document.querySelectorAll('form[action*="borrow"]');
        borrowForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('u sure this book?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush