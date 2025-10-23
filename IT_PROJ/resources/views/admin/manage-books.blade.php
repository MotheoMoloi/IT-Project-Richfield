@extends('layouts.admin')

@section('title', 'Manage Books - Richfield Online Library')

@push('styles')
<style>
    .action-btns {
        white-space: nowrap;
    }
    
    .action-btns form {
        display: inline-block;
    }
    
    .table th {
        background-color: var(--richfield-blue);
        color: white;
    }
    
    .badge-available {
        background-color: #28a745;
    }
    
    .badge-checked_out {
        background-color: #ffc107;
        color: #000;
    }
    
    .badge-reserved {
        background-color: #17a2b8;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-book me-2"></i>Manage Books
                    </div>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary-custom btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Add New Book
                    </a>
                </div>
                <div class="card-body p-4">
                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Book Name</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>ISBN</th>
                                    <th>Year</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($books as $book)
                                <tr>
                                    <td>{{ $book->book_name }}</td>
                                    <td>{{ $book->book_author }}</td>
                                    <td>{{ $book->category ?? 'N/A' }}</td>
                                    <td>{{ $book->isbn }}</td>
                                    <td>{{ $book->year }}</td>
                                    <td>
                                        @if($book->price)
                                            R{{ number_format($book->price, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $book->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $book->status)) }}
                                        </span>
                                        @if($book->active_borrows_count > 0)
                                            <br><small class="text-muted">({{ $book->active_borrows_count }} borrowed)</small>
                                        @endif
                                    </td>
                                    <td class="action-btns">
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.books.delete', $book->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this book? This action cannot be undone.')">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No books found in the library.</p>
                                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary-custom btn-primary">
                                            <i class="fas fa-plus-circle me-2"></i>Add First Book
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($books->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }} results
                        </div>
                        <div>
                            {{ $books->links() }}
                        </div>
                    </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection