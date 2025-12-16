@extends('layout')

@section('content')
<h2>Edit Book</h2>
<form action="{{ route('books.update', $book->book_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3"><label>Title</label><input type="text" name="title" value="{{ $book->title }}" class="form-control" required></div>
    <div class="mb-3"><label>Author</label><input type="text" name="author" value="{{ $book->author }}" class="form-control" required></div>
    <div class="mb-3"><label>ISBN</label><input type="text" name="isbn" value="{{ $book->isbn }}" class="form-control"></div>
    <div class="mb-3"><label>Location</label><input type="text" name="location" value="{{ $book->location }}" class="form-control"></div>
    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control">
            @foreach($categories as $c)
                <option value="{{ $c->category_id }}" {{ $book->category_id == $c->category_id ? 'selected' : '' }}>
                    {{ $c->category_name }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Book</button>
</form>
@endsection