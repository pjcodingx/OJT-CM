

{{-- !THIS IS FOR THE EDIT OF PROFILE OF THE ADMIN
    ! I WILL REMOVE THIS FIRST BECAUSE I WILL RE ARRANGE IT--}}
{{--

<div style="display: flex; align-items: center; gap: 10px;">
    <img src="{{ asset($admin->photo ?? 'default-avatar.png') }}"
        alt="Admin Photo"
        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">

    <div>
        <p><strong>{{ $admin->name }}</strong></p>S
        <a href="{{ route('admin.profile.edit') }}" style="color: blue;">Edit Profile</a>
    </div>
</div> --}}

{{-- ?This is introduction to the admin dashboard. --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCM OJT Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin/adminDashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" sizes="32x32" href="{{ asset('favicon/cmlogo.png') }}" type="image/png">
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
                <img src="{{ asset('uploads/admin_photos/1751962972_369e6f6bb444b8c225b430c41c33ba41.jpg') }}" alt="Administrator avatar showing profile icon" class="admin-avatar">
                <span class="admin-text">{{ $admin->name }}</span>
            </div>

            <!-- mENU -->
            <nav class="sidebar-nav">
                <ul class="nav-list">

                    <li class="nav-item active">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.index') ? 'active' : '' }}"  style="color: inherit; text-decoration: none;">
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
                        <a href="{{ route('admin.companies.index') }}" class="nav-link {{ request()->routeIs('admin.companies.index') ? 'active' : ''}}" style="color: inherit; text-decoration: none;">
                            <i class="fas fa-building nav-icon"></i>
                            <span class="nav-text">Manage Companies</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.attendance') }}" class="nav-link {{ request()->routeIs('admin.attendance') ? 'active' : ''}}" style="color: inherit; text-decoration: none;">
                            <i class="fas fa-clipboard-list nav-icon"></i>
                            <span class="nav-text">Attendance Logs</span>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <i class="fas fa-exclamation-triangle nav-icon"></i>
                        <span class="nav-text">Attendance Appeals</span>
                    </li> --}}



                    <li class="nav-item">
                        <i class="fas fa-tasks nav-icon"></i>
                        <span class="nav-text">Task Monitoring</span>
                    </li>

                    {{-- <li class="nav-item">
                        <i class="fas fa-comments nav-icon"></i>
                        <span class="nav-text">Feedback & Remarks</span>
                    </li> --}}

                    <li class="nav-item">
                        <i class="fas fa-bell nav-icon"></i>
                        <span class="nav-text">Notifications</span>
                    </li>

                    {{-- <li class="nav-item">
                        <i class="fas fa-cog nav-icon"></i>
                        <span class="nav-text">System Settings</span>
                    </li> --}}


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
                <h1 class="dashboard-title">Dashboard</h1>

                <!-- Info Cards -->
                <div class="info-cards">
                    <div class="info-card blue-card">
                        <div class="card-content">
                            <h3 class="card-title">Number of Trainees</h3>
                            <div class="card-number">{{ $studentCount }}</div>
                            <a href="{{ route('admin.students.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>

                    <div class="info-card green-card">
                        <div class="card-content">
                            <h3 class="card-title">Number of Advisers</h3>
                            <div class="card-number">{{ $facultyCount }}</div>
                            <a href="{{ route('admin.faculties.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>

                    <div class="info-card red-card">
                        <div class="card-content">
                            <h3 class="card-title">Number of Agencies</h3>
                            <div class="card-number">{{ $companyCount }}</div>
                            <a href="{{ route('admin.companies.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>

                    <div class="info-card yellow-card">
                        <div class="card-content">
                            <h3 class="card-title">Number of Courses</h3>
                            <div class="card-number">{{ $courseCount }} </div>
                            <a href="#" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>







