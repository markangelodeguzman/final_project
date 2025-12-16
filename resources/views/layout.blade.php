<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraryOS</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font: Inter (Clean & Modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --bg-color: #f8f9fc;
            --card-radius: 12px;
            --font-main: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            font-family: var(--font-main);
            color: #4a5568;
            -webkit-font-smoothing: antialiased;
        }

        /* --- Minimal Navbar --- */
        .navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color) !important;
            letter-spacing: -0.5px;
        }
        .nav-link {
            color: #718096 !important;
            font-weight: 500;
            font-size: 0.95rem;
            margin-left: 15px;
            transition: color 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--accent-color) !important;
        }
        .nav-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #a0aec0;
            margin-top: 6px;
        }

        /* --- Cards & Containers --- */
        .card {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: white;
        }
        .card:hover {
            box-shadow: 0 10px 15px rgba(0,0,0,0.05);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #edf2f7;
            font-weight: 600;
            color: var(--primary-color);
            padding: 1.25rem;
            border-radius: var(--card-radius) var(--card-radius) 0 0 !important;
        }

        /* --- Buttons & Inputs --- */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            font-size: 0.9rem;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #1a252f;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1rem;
            background-color: #fcfcfc;
        }
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        /* --- Tables --- */
        .table {
            margin-bottom: 0;
        }
        .table th {
            font-weight: 600;
            color: #718096;
            font-size: 0.85rem;
            text-transform: uppercase;
            border-bottom: 2px solid #edf2f7;
            padding: 1rem;
        }
        .table td {
            padding: 1rem;
            vertical-align: middle;
            color: #2d3748;
            border-bottom: 1px solid #edf2f7;
        }

        /* --- Status Badges --- */
        .badge {
            font-weight: 500;
            padding: 0.5em 0.8em;
            border-radius: 6px;
        }
        .badge.bg-success { background-color: #d1fae5 !important; color: #065f46; } /* Soft Green */
        .badge.bg-warning { background-color: #fef3c7 !important; color: #92400e; } /* Soft Orange */
        .badge.bg-danger { background-color: #fee2e2 !important; color: #991b1b; } /* Soft Red */
        .badge.bg-secondary { background-color: #e2e8f0 !important; color: #475569; } /* Soft Gray */

        .page-header { margin-bottom: 2rem; }
        .page-title { font-weight: 700; color: var(--primary-color); letter-spacing: -0.5px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="/">
        📚 Library<span style="color:var(--accent-color)">OS</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/">Catalog</a></li>
        <li class="nav-item"><a class="nav-link" href="/my-history">My Account</a></li>
      </ul>
      
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><span class="nav-label me-3">Management</span></li>
        <li class="nav-item"><a class="nav-link" href="/librarian">Librarian</a></li>
        <li class="nav-item"><a class="nav-link" href="/books">Books</a></li>
        <li class="nav-item"><a class="nav-link" href="/admin" style="color: var(--accent-color) !important;">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
    <!-- Global Alerts -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <span class="me-2">✅</span> {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <span class="me-2">⚠️</span> {{ session('warning') }}
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>