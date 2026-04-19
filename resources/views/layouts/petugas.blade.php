<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SIPINJAM - Petugas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('admin_template/startbootstrap-sb-admin-gh-pages/css/styles.css') }}" rel="stylesheet">

    <style>
        .navbar-custom {
            background: linear-gradient(to right, #0059FF, #3B82F6);
            border-bottom: 3px solid #ffffff30;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: white !important;
        }

        .navbar-custom .nav-link:hover {
            color: #dbeafe !important;
        }

        #sidebarToggle {
            color: white !important;
        }

        .dropdown-menu {
            border-radius: 10px;
        }
    </style>
</head>

<body class="sb-nav-fixed">

{{-- NAVBAR --}}
<nav class="sb-topnav navbar navbar-expand navbar-dark navbar-custom">
    <a class="navbar-brand ps-3 fw-bold" href="{{ route('petugas.dashboard') }}">SIPINJAM</a>

    <button class="btn btn-link btn-sm me-4" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="navbar-nav ms-auto me-3 align-items-center">

        <li class="nav-item text-white me-3">
            <strong>
                {{ Auth::check() ? ucfirst(Auth::user()->role) : 'Guest' }}
            </strong>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>

    </ul>
</nav>

<div id="layoutSidenav">

    {{-- SIDEBAR --}}
    <div id="layoutSidenav_nav">
        @include('partials.sidebar-petugas')
    </div>

    {{-- CONTENT --}}
    <div id="layoutSidenav_content">
        <main class="p-4">
            @yield('content')
        </main>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('admin_template/startbootstrap-sb-admin-gh-pages/js/scripts.js') }}"></script>

</body>
</html>