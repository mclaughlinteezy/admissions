<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'University Admission System')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .navbar-brand {
            font-weight: bold;
            color: #a8a8a8 !important;
        }
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .timeline::before {
            position: absolute;
            left: 15px;
            width: 2px;
            background: #e9ecef;
        }
        .timeline-item.current .timeline-marker {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(255, 193, 7, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #0046be;">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-graduation-cap me-2"></i>MSU Admission
            </a>
            <div class="navbar-nav ms-auto">
                @auth
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" data-toggle="dropdown">
                                    Notifications
                                    @if(auth()->user()->unreadNotifications->count())
                                        <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                                    @endif
                                </a>
                                <div class="dropdown-menu">
                                    @forelse(auth()->user()->unreadNotifications as $notification)
                                        <a class="dropdown-item" href="#">
                                            {{ $notification->data['message'] ?? 'New notification' }}
                                        </a>
                                    @empty
                                        <a class="dropdown-item" href="#">No new notifications</a>
                                    @endforelse
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Layout -->
    <div class="container-fluid">
        <div class="row">
            @auth
                <div class="col-md-2 sidebar text-white p-3">
                    <h5 class="mb-4">
                        {{ Auth::user()->isAdmin() ? 'Admin Panel' : 'Student Portal' }}
                    </h5>
                    <ul class="nav nav-pills flex-column">
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.applications.index') }}" class="nav-link text-white {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt me-2"></i>Applications
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.reports') }}" class="nav-link text-white {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                                    <i class="fas fa-chart-line me-2"></i>Reports
                                </a>
                            </li>
                        @else
                            <li class="nav-item mb-2">
                                <a href="{{ route('student.dashboard') }}" class="nav-link text-white {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('student.application.start') }}" class="nav-link text-white {{ request()->routeIs('student.application.start') || request()->routeIs('student.application.step') ? 'active' : '' }}">
                                    <i class="fas fa-plus me-2"></i>Apply Now
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('student.applications.index') }}" class="nav-link text-white {{ request()->routeIs('student.applications.index') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt me-2"></i>My Applications
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('student.profile') }}" class="nav-link text-white {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-10 p-4">
            @else
                <div class="col-12 p-4">
            @endauth

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                <div class="main-content">
                    @yield('content')
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
