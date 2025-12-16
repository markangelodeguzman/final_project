@extends('layout')

@section('content')
<h2>Add New Book</h2>
<form action="{{ route('books.store') }}" method="POST">
    @csrf
    <div class="mb-3"><label>Title</label><input type="text" name="title" class="form-control" required></div>
    <div class="mb-3"><label>Author</label><input type="text" name="author" class="form-control" required></div>
    <div class="mb-3"><label>ISBN</label><input type="text" name="isbn" class="form-control"></div>
    <div class="mb-3"><label>Location</label><input type="text" name="location" class="form-control"></div>
    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control">
            @foreach($categories as $c)
                <option value="{{ $c->category_id }}">{{ $c->category_name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Save Book</button>
</form>
@endsection