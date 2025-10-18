@extends('layouts.admin')

@section('title', 'Add New Book')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-custom card">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-2"></i>Add New Book
                </div>
                <div class="card-body p-4">
                    <!-- EMIHLE -  form action needs to be updated here too-->
                    <form action="{{ route('admin.books.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="book_name" class="form-label"><i class="fas fa-book text-primary me-2"></i>Book Name</label>
                            <input type="text" name="book_name" id="book_name" class="form-control-custom form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="book_author" class="form-label"><i class="fas fa-user text-primary me-2"></i>Author</label>
                            <input type="text" name="book_author" id="book_author" class="form-control-custom form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="isbn" class="form-label"><i class="fas fa-tags text-primary me-2"></i>ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-control-custom form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label"><i class="fas fa-hashtag text-primary me-2"></i>Year</label>
                            <input type="text" name="year" id="year" class="form-control-custom form-control" required>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" name="add_book" class="btn btn-primary-custom btn-primary">
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