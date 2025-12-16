@extends('layout')

@section('content')

<div class="page-header">
    <h2 class="page-title">Admin Console</h2>
    <p class="text-muted">System configuration and user management.</p>
</div>

<div class="row g-4">
    <!-- LEFT COLUMN: System Settings -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">⚙️ System Parameters</div>
            <div class="card-body">
                <form action="{{ route('admin.settings') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase fw-bold">Loan Duration (Days)</label>
                        <input type="number" name="loan_duration_days" class="form-control" value="{{ $settings['loan_duration_days'] }}">
                        <div class="form-text">Default days allowed for borrowing.</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small text-uppercase fw-bold">Penalty Per Day (PHP)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">₱</span>
                            <input type="number" step="0.01" name="penalty_per_day" class="form-control border-start-0" value="{{ $settings['penalty_per_day'] }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Parameters</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-danger">⚠️ Danger Zone</div>
            <div class="card-body">
                <p class="small text-muted mb-3">Remove pending requests that have been inactive for > 30 days.</p>
                <a href="{{ route('admin.cleanup') }}" class="btn btn-outline-danger btn-sm w-100">Run System Cleanup</a>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: User Management -->
    <div class="col-md-8">
        <!-- Add Patron -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Manage Patrons</span>
                <span class="badge bg-secondary">{{ count($patrons) }} Total</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.patron.store') }}" method="POST" class="row g-2 mb-4">
                    @csrf
                    <div class="col-md-3"><input type="text" name="first_name" class="form-control form-control-sm" placeholder="First Name" required></div>
                    <div class="col-md-3"><input type="text" name="last_name" class="form-control form-control-sm" placeholder="Last Name" required></div>
                    <div class="col-md-4"><input type="email" name="email" class="form-control form-control-sm" placeholder="Email Address"></div>
                    <div class="col-md-2"><button class="btn btn-success btn-sm w-100">Add New</button></div>
                </form>

                <div class="table-responsive" style="max-height: 250px;">
                    <table class="table table-sm table-hover border-top">
                        <thead class="bg-light"><tr><th>ID</th><th>Name</th><th>Email</th><th class="text-end">Action</th></tr></thead>
                        <tbody>
                            @foreach($patrons as $p)
                            <tr>
                                <td class="text-muted">#{{ $p->patron_id }}</td>
                                <td class="fw-bold">{{ $p->first_name }} {{ $p->last_name }}</td>
                                <td class="text-muted">{{ $p->email }}</td>
                                <td class="text-end"><a href="{{ route('admin.patron.delete', $p->patron_id) }}" class="text-danger small text-decoration-none">Remove</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Librarian -->
        <div class="card">
            <div class="card-header">Manage Librarians</div>
            <div class="card-body">
                <form action="{{ route('admin.librarian.store') }}" method="POST" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-4"><input type="text" name="first_name" class="form-control form-control-sm" placeholder="First Name" required></div>
                    <div class="col-md-4"><input type="text" name="last_name" class="form-control form-control-sm" placeholder="Last Name" required></div>
                    <div class="col-md-4"><button class="btn btn-primary btn-sm w-100">Add Staff</button></div>
                </form>
                
                <table class="table table-sm border-top">
                    <tbody>
                        @foreach($librarians as $l)
                        <tr>
                            <td class="text-muted">#{{ $l->librarian_id }}</td>
                            <td class="fw-bold">{{ $l->first_name }} {{ $l->last_name }}</td>
                            <td class="text-end"><a href="{{ route('admin.librarian.delete', $l->librarian_id) }}" class="text-danger small text-decoration-none">Remove</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection