{{-- !THIS IS THE COMPANY LAYOUT --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Company Dashboard')</title>

    <link rel="stylesheet" href="{{ asset('css/admin/adminDashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" sizes="32x32" href="{{ asset('favicon/cmlogo.png') }}" type="image/png">

    @yield('styles')
</head>
<body>

    <div class="dashboard-container">


        <div class="sidebar">

            <div class="sidebar-header">
                <img src="{{ asset('images/cmlogo.png') }}" alt="TCM Logo" class="sidebar-logo">
                <span class="sidebar-title">OJT Monitoring</span>
            </div>


            <div class="admin-section">
                <img src="{{ asset('uploads/company_photos/' . ($company->photo ?? 'default.png')) }}" alt="Company Photo" class="admin-avatar">
                <span class="admin-text">{{ $company->name ?? 'Company' }}</span>
            </div>


            <nav class="sidebar-nav">
                <ul class="nav-list">


                    <li class="nav-item {{ request()->routeIs('company.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('company.dashboard') }}" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>


                    <li class="nav-item {{ request()->routeIs('company.profile') ? 'active' : '' }}">
                        <a href="{{ route('company.profile') }}" class="nav-link">
                            <i class="fas fa-user nav-icon"></i>
                            <span class="nav-text">My Profile</span>
                        </a>
                    </li>


                    <li class="nav-item {{ request()->routeIs('company.students.index') ? 'active' : '' }}">
                        <a href="{{ route('company.students.index') }}" class="nav-link">
                            <i class="fas fa-users nav-icon"></i>
                            <span class="nav-text">Assigned Students</span>
                        </a>
                    </li>


                    <li class="nav-item {{ request()->routeIs('company.attendance-appeals.index') ? 'active' : '' }}">
                        <a href="{{ route('company.attendance-appeals.index') }}" class="nav-link">
                            <i class="fas fa-envelope-open-text nav-icon"></i>
                            <span class="nav-text">Attendance Appeals</span>
                        </a>
                    </li>


                    <li class="nav-item {{ request()->routeIs('company.students.ratings.index') ? 'active' : '' }}">
                        <a href="{{ route('company.students.rating.index') }}" class="nav-link">
                            <i class="fas fa-star nav-icon"></i>
                            <span class="nav-text">Rate Students</span>
                        </a>
                    </li>


                    <li class="nav-item {{ request()->routeIs('company.attendance.scanner') ? 'active' : '' }}">
                        <a href="{{ route('company.attendance.scanner') }}" class="nav-link">
                            <i class="fas fa-clock nav-icon"></i>
                            <span class="nav-text">Time In/Out (Camera)</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('company.attendance.logs') ? 'active' : '' }}">
                        <a href="{{ route('company.attendance.logs') }}" class="nav-link">
                            <i class="fas fa-calendar-check nav-icon"></i>
                            <span class="nav-text">Attendance Logs</span>
                        </a>
                    </li>


                   <li class="nav-item {{ request()->routeIs('company.notifications.index') ? 'active' : '' }}">
                        <a href="{{ route('company.notifications.index') }}" class="nav-link">
                            <div class="nav-icon-wrapper">
                                <i class="fas fa-bell nav-icon"></i>
                                @php
                                    use App\Models\Notification;
                                    $unreadCount = Notification::where('user_id', auth('company')->id())
                                        ->where('user_type', 'company')
                                        ->where('is_read', false)
                                        ->count();
                                @endphp

                                @if($unreadCount > 0)
                                    <span class="notification-badge">
                                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                    </span>
                                @endif
                            </div>
                            <span class="nav-text">Notifications</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('company.settings.time_rules') ? 'active' : '' }}">
                        <a href="{{ route('company.settings.time_rules') }}" class="nav-link">
                            <i class="fas fa-cog nav-icon"></i>
                            <span class="nav-text">Time Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>


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

            <!-- Main Dashboard Content -->
            <div class="dashboard-content">
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
