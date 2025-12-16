@extends('layout')

@section('content')

<!-- Identity Bar -->
<div class="card mb-5 border-0 shadow-sm" style="background: #eef2f7;">
    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h4 class="mb-0 fw-bold text-dark">Welcome to the Catalog</h4>
            <p class="mb-0 text-muted small">Select your name to start borrowing books.</p>
        </div>
        <!-- This form will wrap the buttons below, handled via JS usually, 
             but here we keep it simple: Just visual context -->
        <div class="bg-white px-3 py-2 rounded shadow-sm d-flex align-items-center">
            <span class="text-muted small me-2 text-uppercase fw-bold">Current User:</span>
            <span class="text-primary fw-bold">Guest (Select in Book Card)</span>
        </div>
    </div>
</div>

<div class="page-header">
    <h2 class="page-title">Available Books</h2>
    <p class="text-muted">Browse our collection and place a request.</p>
</div>

<div class="row g-4">
    @foreach($books as $book)
    <div class="col-md-4 col-lg-3">
        <div class="card h-100 position-relative overflow-hidden">
            <!-- Decorative Color Strip -->
            <div style="height: 6px; background: {{ $loop->iteration % 2 == 0 ? '#3498db' : '#2c3e50' }};"></div>
            
            <div class="card-body d-flex flex-column">
                <span class="badge bg-secondary w-auto align-self-start mb-2" style="font-size: 0.7rem;">
                    {{ $book->category->category_name ?? 'General' }}
                </span>
                
                <h5 class="card-title fw-bold text-dark mb-1">{{ $book->title }}</h5>
                <p class="card-text text-muted mb-3 small">{{ $book->author }}</p>
                
                <div class="mt-auto pt-3 border-top">
                    <p class="mb-2" style="font-size: 0.8rem;">
                        <span class="text-muted">Location:</span> <strong>{{ $book->location }}</strong>
                    </p>

                    <form action="{{ route('borrow.request') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->book_id }}">
                        
                        <div class="mb-2">
                            <select name="patron_id" class="form-select form-select-sm" required style="font-size: 0.8rem;">
                                <option value="">Select Your Name...</option>
                                @foreach($patrons as $p)
                                    <option value="{{ $p->patron_id }}">{{ $p->first_name }} {{ $p->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            Request Borrow
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection