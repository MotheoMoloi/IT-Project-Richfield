@extends('layouts.admin')

@section('title', 'Edit Book - Richfield Online Library')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-custom card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>Edit Book Details
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.books.update', $book->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="book_name" class="form-label">Book Name</label>
                            <input type="text" class="form-control-custom form-control" id="book_name" name="book_name" value="{{ old('book_name', $book->book_name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="book_author" class="form-label">Author</label>
                            <input type="text" class="form-control-custom form-control" id="book_author" name="book_author" value="{{ old('book_author', $book->book_author) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="isbn" class="form-label">ISBN Number</label>
                            <input type="text" class="form-control-custom form-control" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="year" class="form-label">Publication Year</label>
                            <input type="number" class="form-control-custom form-control" id="year" name="year" value="{{ old('year', $book->year) }}" min="1900" max="{{ date('Y') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control-custom form-control" id="status" name="status" required>
                                <option value="available" {{ $book->status === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="checked_out" {{ $book->status === 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.books.manage') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary-custom btn-primary">
                                <i class="fas fa-save me-2"></i>Update Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection