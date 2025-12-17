@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit Book Details</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('books.update', $book->book_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Book Title</label>
                        <input type="text" name="title" value="{{ $book->title }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <input type="text" name="author" value="{{ $book->author }}" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ISBN</label>
                            <input type="text" name="isbn" value="{{ $book->isbn }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Shelf Location</label>
                            <input type="text" name="location" value="{{ $book->location }}" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            @foreach($categories as $c)
                                <option value="{{ $c->category_id }}" {{ $book->category_id == $c->category_id ? 'selected' : '' }}>
                                    {{ $c->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Update Book</button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection