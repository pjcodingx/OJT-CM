<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome page</title>

    <link rel="stylesheet" href="{{ asset('css/welcome/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" sizes="32x32" href="{{ asset('favicon/cmlogo.png') }}" type="image/png">
</head>
<body>

    {{-- Added Header --}}

    <div class="header">
        <ul>
            <li class="logo"><img src="{{ asset('images/welcome/cmlogo.png') }}" alt="Logo"></li>
            <li class="login-btn">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('images/welcome/user.png') }}" alt="User Icon">
                    <span>Login</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="image-wrapper">
        <img src="{{ asset('images/welcome/students.jpg') }}" alt="Students using computer">
    </div>

    <!-- MESSAGE SECTION -->
    <div class="message">
        <h1>TCM OJT SYSTEM</h1>
        <p>Welcome to the TCM OJT / Internship Placement and Progress Tracking System. This platform helps students, faculty, and partner companies manage OJT placements, monitor attendance using QR codes, and track student progress efficiently. Get started by logging in and accessing the tools designed to support your internship journey.</p>

        <div class="icons">
            <a href="https://www.facebook.com/thecollegeofmaasin/" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="mailto:collegeofmaasin1925@yahoo.com">
                <i class="fas fa-envelope"></i>
            </a>
        </div>
    </div>

    <div class="footer-text">
        @CM 2025
    </div>

</body>
</html>
