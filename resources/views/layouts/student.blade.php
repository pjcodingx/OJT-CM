{{-- !THIS IS THE STUDENT LAYOUT --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard')</title>


    <link rel="stylesheet" href="{{ asset('css/admin/adminDashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" sizes="32x32" href="{{ asset('favicon/cmlogo.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">



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

            <!-- Student Info -->
            <div class="admin-section">
                <img src="{{ asset('uploads/student_photos/' . ($student->photo ?? 'default.png')) }}" alt="Profile Photo" class="admin-avatar">

                <span class="admin-text">{{ $student->name ?? 'Student' }}</span>
            </div>

            <!-- MENU -->
            <nav class="sidebar-nav">
                <ul class="nav-list">

                    <!-- 1. Dashboard Overview -->
                    <li class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('student.dashboard') }}" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- 2. Profile -->
                    <li class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                        <a href="{{ route('student.profile') }}" class="nav-link">
                            <i class="fas fa-user nav-icon"></i>
                            <span class="nav-text">My Profile</span>
                        </a>
                    </li>

                    <!-- 5. Tasks -->
                    <li class="nav-item {{ request()->routeIs('student.journals.create') ? 'active' : '' }}">
                        <a href="{{ route('student.journals.create') }}" class="nav-link">
                            <i class="fas fa-pen nav-icon"></i>
                            <span class="nav-text">Journal Submission</span>
                        </a>
                    </li>



                    <!-- 6. Feedback Section -->
                    <li class="nav-item {{ request()->routeIs('student.feedbacks.index') ? 'active' : '' }}">
                        <a href="{{ route('student.feedbacks.index') }}" class="nav-link">
                            <i class="fas fa-comments nav-icon"></i>
                            <span class="nav-text">Feedback</span>
                        </a>
                    </li>

                    <!-- 7. Attendance Appeals -->
                    <li class="nav-item {{ request()->routeIs('student.attendance-appeals.index') ? 'active' : '' }}">
                        <a href="{{ route('student.attendance-appeals.index') }}" class="nav-link">
                            <i class="fas fa-exclamation-triangle nav-icon"></i>
                            <span class="nav-text">Attendance Appeals</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('student.overtime.index') ? 'active' : '' }}">
                        <a href="{{ route('student.overtime.index') }}" class="nav-link">
                            <i class="fas fa-clock nav-icon"></i>
                            <span class="nav-text">Overtime Requests</span>
                        </a>
                    </li>


                    <!-- 4. Attendance Logs -->
                    <li class="nav-item {{ request()->routeIs('student.attendance.index') ? 'active' : '' }}">
                        <a href="{{ route('student.attendance.index') }}" class="nav-link">
                            <i class="fas fa-calendar-check nav-icon"></i>
                            <span class="nav-text">Attendance Logs</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('student.journals.index') ? 'active' : '' }}">
                        <a href="{{ route('student.journals.index') }}" class="nav-link">
                            <i class="fas fa-tasks nav-icon"></i>
                            <span class="nav-text">Journal logs</span>
                        </a>
                    </li>

                    <!-- 10. Notifications -->
                     <li class="nav-item {{ request()->routeIs('student.notifications.index') ? 'active' : '' }}">
                        <a href="{{ route('student.notifications.index') }}" class="nav-link">
                            <div class="nav-icon-wrapper">
                                <i class="fas fa-bell nav-icon"></i>
                                @php
                                    use App\Models\Notification;
                                    $unreadCount = Notification::where('user_id', auth('student')->id())
                                        ->where('user_type', 'student')
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

                    <li class="nav-item {{ request()->routeIs('reports.student.summary.preview') ? 'active' : '' }}">

                        @php
                            $student = auth('student')->user();
                        @endphp

                        <a href="{{ route('reports.student.summary.preview', ['id' => $student->id]) }}" class="nav-link" target="_blank">
                            <i class="fas fa-file-download nav-icon"></i>
                            <span class="nav-text">Preview Summary</span>
                        </a>
                    </li>

                   <li class="nav-item {{ request()->routeIs('certificate.preview') ? 'active' : '' }}">
                        <a href="{{ route('certificate.preview', $student->id) }}" class="nav-link">
                            <i class="fas fa-certificate nav-icon"></i>
                            <span class="nav-text">Generate Certificate</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <!-- Logout -->
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
                   <span span class="hamburger-line"></span>
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


{{-- implement soon calendar --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
<script>
const hamburger = document.querySelector('.hamburger-menu');
const sidebar = document.querySelector('.sidebar');
const mainContent = document.querySelector('.main-content');
const topBar = document.querySelector('.top-bar');

hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('sidebar-collapsed');
    mainContent.classList.toggle('sidebar-collapsed');
    topBar.classList.toggle('sidebar-collapsed');


    if (window.innerWidth <= 767) {
        document.body.classList.toggle('sidebar-open');
    }
});


document.addEventListener('click', (e) => {
    if (window.innerWidth <= 767 &&
        document.body.classList.contains('sidebar-open') &&
        !sidebar.contains(e.target) &&
        !hamburger.contains(e.target)) {
        sidebar.classList.remove('sidebar-collapsed');
        mainContent.classList.remove('sidebar-collapsed');
        topBar.classList.remove('sidebar-collapsed');
        document.body.classList.remove('sidebar-open');
    }
});


window.addEventListener('resize', () => {
    if (window.innerWidth > 767) {
        document.body.classList.remove('sidebar-open');
    }
});


</script>



</body>
</html>
