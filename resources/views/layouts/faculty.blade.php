{{-- !THIS IS THE FACULTY LAYOUT --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OJT Adviser Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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


            <div class="admin-section">
                <img src="{{ asset('uploads/faculty_photos/' . ($faculty->photo ?? 'default.png')) }}" alt="Profile Photo" class="admin-avatar">
                <span class="admin-text">{{ $faculty->name ?? 'Faculty' }}</span>
            </div>


            <nav class="sidebar-nav">
                <ul class="nav-list">

                    <!-- 1. Dashboard -->
                    <li class="nav-item {{ request()->routeIs('faculty.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('faculty.dashboard') }}" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>


                    <li class="nav-item {{ request()->routeIs('faculty.manage-companies.index') ? 'active' : '' }}">
                        <a href="{{ route('faculty.manage-companies.index') }}" class="nav-link " style="color: inherit; text-decoration: none;">
                            <i class="fas fa-chalkboard-teacher nav-icon"></i>
                            <span class="nav-text">Manage Companies</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('faculty.manage-students.*') ? 'active' : '' }}">
                        <a href="{{ route('faculty.manage-students.index') }}" class="nav-link" style="color: inherit; text-decoration: none;">
                            <i class="fas fa-user-graduate nav-icon"></i>
                            <span class="nav-text">Manage Students</span>
                        </a>
                    </li>


                    <!-- 3. Task Management -->
                    <li class="nav-item {{ request()->routeIs('faculty.journals.index') ? 'active' : '' }}">
                        <a href="{{ route('faculty.journals.index') }}" class="nav-link">
                            <i class="fas fa-tasks nav-icon"></i>
                            <span class="nav-text">Journal Submissions</span>
                        </a>
                    </li>

                    <!-- 4. Company Feedback -->
                    <li class="nav-item {{ request()->routeIs('faculty.feedbacks.index') ? 'active' : '' }}">
                        <a href="{{ route('faculty.feedbacks.index') }}" class="nav-link">
                            <i class="fas fa-briefcase nav-icon"></i>
                            <span class="nav-text">Company Feedback</span>
                        </a>
                    </li>

                    <!-- 5. Attendance Overview -->
                    <li class="nav-item {{ request()->routeIs('faculty.attendance.logs') ? 'active' : '' }}">
                        <a href="{{ route('faculty.attendance.logs') }}" class="nav-link">
                            <i class="fas fa-calendar-check nav-icon"></i>
                            <span class="nav-text">Attendance Overview</span>
                        </a>
                    </li>

                            <li class="nav-item {{ request()->routeIs('faculty.notifications.index') ? 'active' : '' }}">
                                <a href="{{ route('faculty.notifications.index') }}" class="nav-link">
                                    <div class="nav-icon-wrapper">
                                        <i class="fas fa-bell nav-icon"></i>
                                        @php
                                            use App\Models\Notification;
                                            $unreadCount = Notification::where('user_id', auth('faculty')->id())
                                                ->where('user_type', 'faculty')
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


                    <!-- 10. Reports / PDF Summary -->
                    <li class="nav-item {{ request()->routeIs('faculty.reports.index') ? 'active' : '' }}">
                        <a href="{{ route('faculty.reports.index') }}" class="nav-link">
                            <i class="fas fa-file-pdf nav-icon"></i>
                            <span class="nav-text">Summary Reports</span>
                        </a>
                    </li>

                    <!-- 9. Profile Settings -->
                    <li class="nav-item {{ request()->routeIs('faculty.profile') ? 'active' : '' }}">
                        <a href="{{ route('faculty.profile') }}" class="nav-link">
                            <i class="fas fa-user-cog nav-icon"></i>
                            <span class="nav-text"> Profile</span>
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
document.getElementById('notificationToggle').addEventListener('click', function(e) {
    e.preventDefault();
    let dropdown = document.getElementById('notificationDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';

    fetch("{{ route('faculty.notifications.readAll') }}", {
    method: "POST",
    headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Content-Type": "application/json"
    }
});

});



function updateNotificationBadge(count) {
    const badge = document.querySelector('.notification-badge');
    const iconWrapper = document.querySelector('.nav-icon-wrapper');

    if (count > 0) {
        if (badge) {

            badge.textContent = count > 99 ? '99+' : count;


            badge.classList.remove('high-count', 'critical-count');
            if (count > 50) {
                badge.classList.add('critical-count');
            } else if (count > 10) {
                badge.classList.add('high-count');
            }
        } else {

            const newBadge = document.createElement('span');
            newBadge.className = 'notification-badge';
            newBadge.textContent = count > 99 ? '99+' : count;

            if (count > 50) {
                newBadge.classList.add('critical-count');
            } else if (count > 10) {
                newBadge.classList.add('high-count');
            }

            iconWrapper.appendChild(newBadge);
        }
    } else {

        if (badge) {
            badge.remove();
        }
    }
}


function refreshNotificationCount() {
    fetch('/faculty/notifications/count', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        updateNotificationBadge(data.unread_count);
    })
    .catch(error => {
        console.error('Error fetching notification count:', error);
    });
}


setInterval(refreshNotificationCount, 30000);


function markNotificationAsRead(notificationId) {
    fetch(`/faculty/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateNotificationBadge(data.unread_count);
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}


document.addEventListener('DOMContentLoaded', function() {

    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.style.transition = 'all 0.3s ease';
    });
});




</script>
</body>
</html>
