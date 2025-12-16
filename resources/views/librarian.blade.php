@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title">Librarian Dashboard</h2>
        <p class="text-muted">Overview of requests and active loans.</p>
    </div>
    <div>
        <a href="/books" class="btn btn-outline-primary btn-sm me-2">Manage Books</a>
    </div>
</div>

<!-- SECTION 1: PENDING REQUESTS -->
<div class="card mb-5">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <span class="text-warning fw-bold">🟠 Pending Requests</span>
        <span class="badge bg-warning text-dark">{{ $pendingRequests->count() }} items</span>
    </div>
    <div class="card-body p-0">
        @if($pendingRequests->isEmpty())
            <div class="p-4 text-center text-muted">No pending requests at the moment.</div>
        @else
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Book</th>
                        <th>Patron</th>
                        <th>Requested Date</th>
                        <th class="text-end">Decision</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingRequests as $req)
                    <tr>
                        <td class="fw-bold">{{ $req->book->title }}</td>
                        <td>{{ $req->patron->first_name }} {{ $req->patron->last_name }}</td>
                        <td class="text-muted small">{{ $req->borrow_date }}</td>
                        <td class="text-end">
                            <a href="{{ route('borrow.approve', $req->borrow_id) }}" class="btn btn-sm btn-success px-3 me-1">Approve</a>
                            <a href="{{ route('borrow.decline', $req->borrow_id) }}" class="btn btn-sm btn-outline-danger">Decline</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<!-- SECTION 2: ACTIVE LOANS -->
<div class="card mb-5">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <span class="text-success fw-bold">🟢 Active Loans</span>
        <span class="badge bg-success">{{ $activeLoans->count() }} active</span>
    </div>
    <div class="card-body p-0">
        @if($activeLoans->isEmpty())
            <div class="p-4 text-center text-muted">No books currently borrowed.</div>
        @else
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Book Details</th>
                        <th>Patron</th>
                        <th>Due Date</th>
                        <th class="text-end">Return</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeLoans as $loan)
                    <tr>
                        <td>
                            <span class="fw-bold text-dark d-block">{{ $loan->book->title }}</span>
                            <span class="small text-muted">{{ $loan->book->author }}</span>
                        </td>
                        <td>{{ $loan->patron->first_name }} {{ $loan->patron->last_name }}</td>
                        <td>
                            <span class="d-block">{{ $loan->due_date }}</span>
                            @if(\Carbon\Carbon::now()->gt($loan->due_date))
                                <span class="badge bg-danger mt-1">OVERDUE</span>
                            @else
                                <span class="badge bg-success mt-1">On Time</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('borrow.return', $loan->borrow_id) }}" class="btn btn-primary btn-sm">Receive Book</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<!-- SECTION 3: SEARCH HISTORY -->
<div class="card">
    <div class="card-header bg-white">
        <div class="row align-items-center">
            <div class="col">
                <span class="text-secondary fw-bold">🕒 Returns History</span>
            </div>
            <div class="col-auto">
                <form action="/librarian" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Patron/Book..." style="width: 200px;">
                    <button type="submit" class="btn btn-light btn-sm border">Search</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-sm text-muted mb-0">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Patron</th>
                    <th>Return Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $h)
                <tr>
                    <td>{{ $h->book->title }}</td>
                    <td>{{ $h->patron->first_name }} {{ $h->patron->last_name }}</td>
                    <td>{{ $h->return_date }}</td>
                    <td><span class="badge bg-secondary">Returned</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection