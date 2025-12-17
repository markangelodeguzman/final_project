@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Book</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Book Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Introduction to Java" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <input type="text" name="author" class="form-control" placeholder="e.g. John Doe" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ISBN</label>
                            <input type="text" name="isbn" class="form-control" placeholder="Optional">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shelf Location</label>
                            <input type="text" name="location" class="form-control" placeholder="e.g. Shelf A-1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->category_id }}">{{ $c->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">Save Book</button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection