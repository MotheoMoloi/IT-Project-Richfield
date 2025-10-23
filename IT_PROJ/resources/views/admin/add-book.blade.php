@extends('layouts.admin')

@section('title', 'Add New Book - Richfield Online Library')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-custom card">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-2"></i>Add New Book
                </div>
                <div class="card-body p-4">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.books.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="book_name" class="form-label">
                                <i class="fas fa-book text-primary me-2"></i>Book Name
                            </label>
                            <input type="text" class="form-control-custom form-control @error('book_name') is-invalid @enderror" 
                                   id="book_name" name="book_name" 
                                   value="{{ old('book_name') }}" required>
                            @error('book_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="book_author" class="form-label">
                                <i class="fas fa-user text-primary me-2"></i>Author
                            </label>
                            <input type="text" class="form-control-custom form-control @error('book_author') is-invalid @enderror" 
                                   id="book_author" name="book_author" 
                                   value="{{ old('book_author') }}" required>
                            @error('book_author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">
                                <i class="fas fa-tags text-primary me-2"></i>Category
                            </label>
                            <input type="text" class="form-control-custom form-control @error('category') is-invalid @enderror" 
                                   id="category" name="category" 
                                   value="{{ old('category') }}"
                                   placeholder="e.g., Computer Science, Fiction, Business">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="isbn" class="form-label">
                                <i class="fas fa-barcode text-primary me-2"></i>ISBN Number
                            </label>
                            <input type="text" class="form-control-custom form-control @error('isbn') is-invalid @enderror" 
                                   id="isbn" name="isbn" 
                                   value="{{ old('isbn') }}" required>
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="year" class="form-label">
                                        <i class="fas fa-calendar text-primary me-2"></i>Publication Year
                                    </label>
                                    <input type="number" class="form-control-custom form-control @error('year') is-invalid @enderror" 
                                           id="year" name="year" 
                                           value="{{ old('year') }}" 
                                           min="1900" max="{{ date('Y') }}" required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">
                                        <i class="fas fa-money-bill text-primary me-2"></i>Price (ZAR)
                                    </label>
                                    <input type="number" step="0.01" class="form-control-custom form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" 
                                           value="{{ old('price') }}"
                                           placeholder="0.00">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">
                                <i class="fas fa-info-circle text-primary me-2"></i>Status
                            </label>
                            <select class="form-control-custom form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="checked_out" {{ old('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                                <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.books.manage') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary-custom btn-primary">
                                <i class="fas fa-save me-2"></i>Add Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection