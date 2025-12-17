@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Book Management</h2>
    <a href="{{ route('books.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Add New Book
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>{{ $book->book_id }}</td>
                        <td class="fw-bold">{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->category->category_name ?? 'N/A' }}</td>
                        <td>{{ $book->location }}</td>
                        <td>
                            @if($book->availability_status == 'available')
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ ucfirst($book->availability_status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('books.edit', $book->book_id) }}" class="btn btn-sm btn-primary">Edit</a>
                            
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
        </div>
    </div>
</div>
@endsection