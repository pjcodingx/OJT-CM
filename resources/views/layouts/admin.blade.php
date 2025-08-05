
{{-- !THIS WILL BE USED FOR ALL ROLE PAGES --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TCM OJT Dashboard')</title>

    <link rel="stylesheet" href="{{ asset('css/admin/adminDashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" sizes="32x32" href="{{ asset('favicon/cmlogo.png') }}" type="image/png">

    @yield('styles')
</head>
<body>

    <div class="dashboard-container">

        <div class="sidebar">
            <!-- CM LOGO -->
            <div class="sidebar-header">
                <img src="{{ asset('images/cmlogo.png') }}" alt="TCM Logo" class="sidebar-logo">
                <span class="sidebar-title">OJT Monitoring</span>
            </div>

            <!-- Admin profile or Name -->
            <div class="admin-section">
                <img src="{{ asset('uploads/admin_photos/1751962972_369e6f6bb444b8c225b430c41c33ba41.jpg') }}" alt="Admin avatar" class="admin-avatar">
                <span class="admin-text">{{ $admin->name ?? 'Admin' }}</span>
            </div>

            <!-- MENU -->
            <nav class="sidebar-nav">
                <ul class="nav-list">

                    <li class="nav-item {{ request()->routeIs('admin/dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link" style="color: inherit; text-decoration: none;">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.students.index') }}" class="nav-link" style="color: inherit; text-decoration: none;">
                            <i class="fas fa-user-graduate nav-icon"></i>
                            <span class="nav-text">Manage Students</span>
                        </a>
                    </li>

                   <li class="nav-item">
                        <a href="{{ route('admin.faculties.index') }}" class="nav-link {{ request()->routeIs('admin.faculties.index') ? 'active' : '' }}" style="color: inherit; text-decoration: none;">
                            <i class="fas fa-chalkboard-teacher nav-icon"></i>
                            <span class="nav-text">Manage Advisers</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.companies.index') }}" class="nav-link {{ request()->routeIs('admin.companies.index') ? 'active' : '' }}" style="color: inherit; text-decoration: none;">
                            <i class="fas fa-building nav-icon"></i>
                            <span class="nav-text">Manage Companies</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                        <span class="nav-text">Attendance Logs</span>
                    </li>
                    <li class="nav-item">
                        <i class="fas fa-exclamation-triangle nav-icon"></i>
                        <span class="nav-text">Attendance Appeals</span>
                    </li>
                    <li class="nav-item">
                        <i class="fas fa-tasks nav-icon"></i>
                        <span class="nav-text">Task Monitoring</span>
                    </li>
                    <li class="nav-item">
                        <i class="fas fa-comments nav-icon"></i>
                        <span class="nav-text">Feedback & Remarks</span>
                    </li>
                    <li class="nav-item">
                        <i class="fas fa-bell nav-icon"></i>
                        <span class="nav-text">Notifications</span>
                    </li>
                    <li class="nav-item">
                        <i class="fas fa-cog nav-icon"></i>
                        <span class="nav-text">System Settings</span>
                    </li>
                </ul>
            </nav>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <div class="logout-section">
                    <button type="submit" class="logout-btn">Logout</button>
                </div>
            </form>
        </div>

        <div class="main-content">
            <div class="top-bar">
                <button class="hamburger-menu">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
