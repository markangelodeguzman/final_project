@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Librarian Dashboard</h2>
    <a href="/books" class="btn btn-outline-primary">Manage Book Inventory</a>
</div>

<!-- Pending Requests -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-warning text-dark fw-bold">
        Pending Borrow Requests
    </div>
    <div class="card-body">
        @if($pendingRequests->isEmpty())
            <p class="text-muted mb-0">No pending requests.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Patron Name</th>
                            <th>Date Requested</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequests as $req)
                        <tr>
                            <td>{{ $req->book->title }}</td>
                            <td>{{ $req->patron->first_name }} {{ $req->patron->last_name }}</td>
                            <td>{{ $req->borrow_date }}</td>
                            <td>
                                <a href="{{ route('borrow.approve', $req->borrow_id) }}" class="btn btn-success btn-sm">Approve</a>
                                <a href="{{ route('borrow.decline', $req->borrow_id) }}" class="btn btn-danger btn-sm">Decline</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Active Loans -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-white fw-bold">
        Active Loans
    </div>
    <div class="card-body">
        @if($activeLoans->isEmpty())
            <p class="text-muted mb-0">No active loans.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Book</th>
                            <th>Patron</th>
                            <th>Due Date</th>
                            <th>Return</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeLoans as $loan)
                        <tr>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->patron->first_name }} {{ $loan->patron->last_name }}</td>
                            <td>
                                {{ $loan->due_date }}
                                @if(\Carbon\Carbon::now()->gt($loan->due_date))
                                    <span class="badge bg-danger">OVERDUE</span>
                                @else
                                    <span class="badge bg-success">On Time</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('borrow.return', $loan->borrow_id) }}" class="btn btn-primary btn-sm">Return Book</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- History -->
<div class="card shadow-sm">
    <div class="card-header bg-secondary text-white fw-bold d-flex justify-content-between align-items-center">
        <span>Returns History</span>
        <form action="/librarian" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search...">
            <button type="submit" class="btn btn-light btn-sm">Go</button>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-sm table-hover text-muted mb-0">
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
                    <td>{{ $h->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection