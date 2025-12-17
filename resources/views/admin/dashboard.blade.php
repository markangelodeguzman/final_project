@extends('layout')

@section('content')

<h2 class="mb-4 pb-2 border-bottom">System Administrator</h2>

<div class="row">
    <!-- LEFT: Settings -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">System Parameters</div>
            <div class="card-body">
                <form action="{{ route('admin.settings') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Loan Duration (Days)</label>
                        <input type="number" name="loan_duration_days" class="form-control" value="{{ $settings['loan_duration_days'] }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penalty Per Day (Amount)</label>
                        <input type="number" step="0.01" name="penalty_per_day" class="form-control" value="{{ $settings['penalty_per_day'] }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Settings</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-danger">
            <div class="card-header bg-danger text-white">Maintenance</div>
            <div class="card-body">
                <p class="card-text small">Delete pending requests older than 30 days.</p>
                <a href="{{ route('admin.cleanup') }}" class="btn btn-outline-danger w-100">Run Cleanup</a>
            </div>
        </div>
    </div>

    <!-- RIGHT: Management -->
    <div class="col-md-8">
        <!-- Patrons -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">Manage Patrons</div>
            <div class="card-body">
                <form action="{{ route('admin.patron.store') }}" method="POST" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-3">
                        <input type="text" name="first_name" class="form-control form-control-sm" placeholder="First Name" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="last_name" class="form-control form-control-sm" placeholder="Last Name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="Email">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success btn-sm w-100">Add</button>
                    </div>
                </form>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patrons as $p)
                        <tr>
                            <td>{{ $p->patron_id }}</td>
                            <td>{{ $p->first_name }} {{ $p->last_name }}</td>
                            <td>{{ $p->email }}</td>
                            <td><a href="{{ route('admin.patron.delete', $p->patron_id) }}" class="btn btn-danger btn-sm py-0">Delete</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Librarians -->
        <div class="card shadow-sm">
            <div class="card-header bg-light fw-bold">Manage Librarians</div>
            <div class="card-body">
                <form action="{{ route('admin.librarian.store') }}" method="POST" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-4">
                        <input type="text" name="first_name" class="form-control form-control-sm" placeholder="First Name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="last_name" class="form-control form-control-sm" placeholder="Last Name" required>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm w-100">Add Librarian</button>
                    </div>
                </form>

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($librarians as $l)
                        <tr>
                            <td>{{ $l->librarian_id }}</td>
                            <td>{{ $l->first_name }} {{ $l->last_name }}</td>
                            <td><a href="{{ route('admin.librarian.delete', $l->librarian_id) }}" class="btn btn-danger btn-sm py-0">Delete</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection