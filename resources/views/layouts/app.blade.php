<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow - @yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body { background: #F4F3FF; font-family: sans-serif; }

        #sidebar {
            width: 250px;
            height: 100vh;
            background: #0F0E17;
            position: fixed;
            color: white;
        }

        #main-content {
            margin-left: 250px;
        }

        .nav-link {
            color: #A8A4C8;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }

        .nav-link:hover {
            background: #6C63FF;
            color: white;
        }

        .topbar {
            background: white;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<div id="sidebar">
    <h4 class="p-3">TaskFlow</h4>

    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
    <a href="{{ route('tasks.index') }}" class="nav-link">Tasks</a>

    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('employees.index') }}" class="nav-link">Employees</a>
            <a href="{{ route('tasks.create') }}" class="nav-link">Assign Task</a>
        @endif
    @endauth

    @auth
        <form method="POST" action="{{ route('logout') }}" class="p-3">
            @csrf
            <button class="btn btn-danger w-100">Logout</button>
        </form>
    @endauth
</div>

<!-- Main Content -->
<div id="main-content">

    <div class="topbar d-flex justify-content-between align-items-center">

        <h5>@yield('page-title', 'Dashboard')</h5>

        @auth
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                ({{ auth()->user()->role }})
            </div>
        @endauth

    </div>

    <div class="p-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
