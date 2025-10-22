@extends('layouts.admin')

@section('title', 'Manage Books - Richfield Online Library')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card-custom card">
                <div class="card-header">
                    <i class="fas fa-book me-2"></i>Manage Books
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Author</th>
                                    <th>ISBN No.</th>
                                    <th>Year</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($books as $book)
                                <tr>
                                    <td>{{ $book->book_name }}</td>
                                    <td>{{ $book->book_author }}</td>
                                    <td>{{ $book->isbn }}</td>
                                    <td>{{ $book->year }}</td>
                                    <td>
                                        <span class="badge bg-{{ $book->status === 'available' ? 'success' : 'warning' }}">
                                            {{ ucfirst($book->status) }}
                                        </span>
                                    </td>
                                    <td class="action-btns">
                                        <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.books.delete', $book->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No books found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary-custom btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Add New Book
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .action-btns a, .action-btns form {
        display: inline-block;
        margin-right: 5px;
    }
</style>
@endpush