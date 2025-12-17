@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>My Account & History</h2>
        <div class="card p-4 mb-4 bg-light">
            <!-- Form to select which Patron you are -->
            <form action="{{ route('patron.history') }}" method="GET" class="d-flex align-items-center">
                <label class="me-3 fw-bold">Select Your Name:</label>
                <select name="patron_id" class="form-select w-50 me-2" required>
                    <option value="">-- Select Patron --</option>
                    @foreach($patrons as $p)
                        <option value="{{ $p->patron_id }}" {{ (isset($selectedPatron) && $selectedPatron->patron_id == $p->patron_id) ? 'selected' : '' }}>
                            {{ $p->first_name }} {{ $p->last_name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">View My Borrows</button>
            </form>
        </div>
    </div>

    @if($selectedPatron)
    <div class="col-md-12">
        <h4>Borrowing Record for: <span class="text-primary">{{ $selectedPatron->first_name }} {{ $selectedPatron->last_name }}</span></h4>
        
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Book Title</th>
                    <th>Borrowed Date</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myBorrows as $borrow)
                <tr>
                    <td>{{ $borrow->book->title }}</td>
                    <td>{{ $borrow->borrow_date }}</td>
                    <td>
                        {{ $borrow->due_date }}
                        <!-- Flag overdue books automatically -->
                        @if(\Carbon\Carbon::now()->gt($borrow->due_date) && $borrow->status == 'active')
                            <span class="badge bg-danger">OVERDUE</span>
                        @endif
                    </td>
                    <td>
                        @if($borrow->status == 'active') 
                            <span class="badge bg-success">Active</span>
                        @elseif($borrow->status == 'pending') 
                            <span class="badge bg-warning text-dark">Pending Approval</span>
                        @elseif($borrow->status == 'returned') 
                            <span class="badge bg-secondary">Returned</span>
                        @endif
                    </td>
                    <td>
                        <!-- Patron can update requests (Extend) if allowed -->
                        @if($borrow->status == 'active')
                            <form action="{{ route('borrow.extend', $borrow->borrow_id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-info text-white">Extend Due Date (+7 Days)</button>
                            </form>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No borrowing history found for this user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection