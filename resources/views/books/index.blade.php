@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Book Management</h2>
    <a href="{{ route('books.create') }}" class="btn btn-success">Add New Book</a>
</div>

<table class="table table-striped table-bordered shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->book_id }}</td>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->category->category_name ?? 'N/A' }}</td>
            <td>
                <span class="badge {{ $book->availability_status == 'available' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ $book->availability_status }}
                </span>
            </td>
            <td>
                <a href="{{ route('books.edit', $book->book_id) }}" class="btn btn-sm btn-primary">Edit</a>
                
                <!-- Delete Button with Confirmation -->
                <form action="{{ route('books.destroy', $book->book_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection