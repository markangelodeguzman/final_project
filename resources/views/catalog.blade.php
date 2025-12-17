@extends('layout')

@section('content')

<div class="row mb-4">
    <div class="col-md-12">
        <div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
            <h1 class="display-5 fw-bold">Library Catalog</h1>
            <p class="col-md-8 fs-4">Welcome to the borrowing system. Please select your name below to request a book.</p>
        </div>
    </div>
</div>

<div class="row">
    @foreach($books as $book)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-transparent border-bottom-0">
                <span class="badge bg-secondary">{{ $book->category->category_name ?? 'General' }}</span>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $book->title }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $book->author }}</h6>
                <p class="card-text">
                    <strong>ISBN:</strong> {{ $book->isbn }}<br>
                    <strong>Location:</strong> {{ $book->location }}
                </p>
            </div>
            <div class="card-footer bg-light border-top-0">
                <form action="{{ route('borrow.request') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->book_id }}">
                    
                    <div class="mb-2">
                        <select name="patron_id" class="form-select form-select-sm" required>
                            <option value="">-- Select Your Name --</option>
                            @foreach($patrons as $p)
                                <option value="{{ $p->patron_id }}">{{ $p->first_name }} {{ $p->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Request Borrow</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection