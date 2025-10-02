<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TCM OJT System - Welcome</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-green: #1b5e20;
            --secondary-green: #2e7d32;
            --light-green: #43a047;
            --accent-green: #66bb6a;
            --dark-bg: #0d3d0f;
            --text-dark: #1a1a1a;
            --text-light: #ffffff;
            --gray: #f5f5f5;
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
            background-color: #f9f9f9;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            padding: 1rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .header ul {
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo img {
            height: 60px;
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.05) rotate(5deg);
        }

        .login-btn a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.95);
            color: var(--primary-green);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-btn a:hover {
            background: var(--text-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .login-btn img {
            width: 24px;
            height: 24px;
        }

        /* Slideshow Styles */
        .slideshow-container {
            position: relative;
            width: 100%;
            height: 500px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1.2s ease-in-out;
            background-size: cover;
            background-position: center;
        }

        .slide.active {
            opacity: 1;
        }

        .slide-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            color: white;
            padding: 2rem;
            transform: translateY(0);
            transition: var(--transition);
        }

        .slide-title {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .slide-description {
            font-size: 1.1rem;
            max-width: 800px;
            line-height: 1.6;
        }

        .slideshow-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .nav-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: var(--transition);
        }

        .nav-dot.active {
            background: var(--text-light);
            transform: scale(1.2);
        }

        .slideshow-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            transform: translateY(-50%);
            z-index: 10;
        }

        .slide-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            backdrop-filter: blur(5px);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* Message Section */
        .message {
            max-width: 1200px;
            margin: 50px auto;
            padding: 4rem 2rem;
            text-align: center;
            position: relative;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin-top: -50px;
            z-index: 2;
        }

        .message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, var(--light-green), var(--accent-green));
            border-radius: 2px;
        }

        .message h1 {
            font-size: 3rem;
            color: var(--primary-green);
            margin: 2rem 0 1.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 3px;
            background: linear-gradient(to right, transparent, var(--accent-green), transparent);
        }

        .message p {
            font-size: 1.15rem;
            line-height: 1.8;
            color: #555;
            max-width: 900px;
            margin: 2rem auto;
            text-align: justify;
            text-align-last: center;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        /* Campus Gallery Section */
        .campus-gallery {
            max-width: 1400px;
            margin: 4rem auto;
            padding: 2rem;
        }

        .gallery-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .gallery-header h2 {
            font-size: 2.5rem;
            color: var(--primary-green);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .gallery-header h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 3px;
            background: linear-gradient(to right, transparent, var(--accent-green), transparent);
        }

        .gallery-header p {
            color: #666;
            font-size: 1.1rem;
            margin-top: 1.5rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transition: var(--transition);
            cursor: pointer;
            height: 280px;
        }

        .gallery-item:hover {
            transform: translateY(-12px);
            box-shadow: 0 16px 40px rgba(27, 94, 32, 0.25);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.15);
        }

        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(27, 94, 32, 0.95), transparent);
            padding: 2rem 1.5rem 1.5rem;
            transform: translateY(100%);
            transition: transform 0.4s ease;
        }

        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }

        .gallery-overlay h3 {
            color: var(--text-light);
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .gallery-overlay p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            padding: 4rem 2rem;
            margin: 4rem 0;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            position: relative;
            z-index: 1;
        }

        .stat-item {
            text-align: center;
            color: var(--text-light);
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: scale(1.1);
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 700;
            display: block;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .stat-label {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        /* Icons Section */
        .icons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            margin-top: 3rem;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, var(--secondary-green), var(--light-green));
            color: var(--text-light);
            border-radius: 50%;
            text-decoration: none;
            font-size: 1.3rem;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(27, 94, 32, 0.3);
            position: relative;
            overflow: hidden;
        }

        .icons a::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }

        .icons a:hover::before {
            width: 100%;
            height: 100%;
        }

        .icons a:hover {
            transform: translateY(-5px) rotate(360deg);
            box-shadow: 0 8px 20px rgba(27, 94, 32, 0.4);
        }

        /* Footer */
        .footer-text {
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--primary-green) 100%);
            color: var(--text-light);
            text-align: center;
            padding: 2rem;
            font-size: 0.95rem;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .logo img {
                height: 45px;
            }

            .login-btn a {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }

            .slideshow-container {
                height: 400px;
            }

            .slide-title {
                font-size: 1.8rem;
            }

            .slide-description {
                font-size: 1rem;
            }

            .message {
                padding: 3rem 1.5rem;
                margin-top: -30px;
            }

            .message h1 {
                font-size: 2rem;
            }

            .message p {
                font-size: 1rem;
                text-align: center;
            }

            .gallery-header h2 {
                font-size: 2rem;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .stats-container {
                gap: 2rem;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .icons a {
                width: 48px;
                height: 48px;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .message h1 {
                font-size: 1.75rem;
            }

            .login-btn a span {
                display: none;
            }

            .gallery-header h2 {
                font-size: 1.75rem;
            }

            .slideshow-container {
                height: 300px;
            }

            .slide-title {
                font-size: 1.5rem;
            }

            .slide-description {
                font-size: 0.9rem;
            }

            .slide-btn {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <ul>
            <li class="logo"><img src="{{ asset('images/cmlogo.png') }}" alt="TCM Logo"></li>
            <li class="login-btn">
                <a href="{{ route('login') }}">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%231b5e20'%3E%3Cpath d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z'/%3E%3C/svg%3E" alt="User Icon">
                    <span>Login</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Slideshow Section -->
    <div class="slideshow-container">

        <div class="slide active" style="background-image: url({{ asset('images/welcome/CMFIRE.jpg') }})">
            <div class="slide-content">
                <h2 class="slide-title">Welcome to TCM OJT System</h2>

            </div>
        </div>

        <div class="slide" style="background-image: url({{ asset('images/welcome/cmFront.jpg') }}">
            <div class="slide-content">
                <h2 class="slide-title">Track Your Progress</h2>

            </div>
        </div>

        <div class="slide" style="background-image: url({{ asset('images/welcome/bsit.jpg') }})">
            <div class="slide-content">
                <h2 class="slide-title">Beautiful Campus Environment</h2>

            </div>
        </div>

        <div class="slide" style="background-image: url({{ asset('images/welcome/HallCm.jpg') }})">
            <div class="slide-content">
                <h2 class="slide-title">Advanced Learning Facilities</h2>

            </div>
        </div>



        <div class="slideshow-controls">
            <button class="slide-btn prev-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slide-btn next-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="slideshow-nav">
            <div class="nav-dot active"></div>
            <div class="nav-dot"></div>
            <div class="nav-dot"></div>
            <div class="nav-dot"></div>
        </div>
    </div>

    <!-- Message Section -->
    <div class="message">
        <h1>TCM OJT MONITORING System</h1>
        <p>Welcome to The College of Maasin OJT/Internship Placement and Progress Tracking System. This comprehensive platform seamlessly connects students, faculty, and partner companies to manage OJT placements efficiently. Monitor attendance through innovative QR code technology, track student progress in real-time, and access powerful tools designed to support every step of your internship journey.</p>

        <div class="icons">
            <a href="https://www.facebook.com/thecollegeofmaasin/" target="_blank" title="Visit our Facebook page">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="mailto:collegeofmaasin1925@yahoo.com" title="Email us">
                <i class="fas fa-envelope"></i>
            </a>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <span class="stat-number">100+</span>
                <span class="stat-label">Years of Excellence</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">1000+</span>
                <span class="stat-label">Students Enrolled</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">20+</span>
                <span class="stat-label">Partner Companies</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">95%</span>
                <span class="stat-label">Success Rate</span>
            </div>
        </div>
    </div>

    <!-- Campus Gallery Section -->
    <div class="campus-gallery">
        <div class="gallery-header">
            <h2>The College Of Maasin</h2>
            <p>Discover the vibrant learning environment at The College of Maasin</p>
        </div>

        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="{{ asset('images/welcome/cmAC.jpg') }}" alt="Campus Building">
                <div class="gallery-overlay">
                    <h3>Modern Facilities</h3>
                    <p>With these airconditioned accreditation hall</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="{{ asset('images/welcome/labcm.jpg') }}" alt="Computer Lab">
                <div class="gallery-overlay">
                    <h3>Tech-Equipped Labs</h3>
                    <p>Advanced computer labs with latest technology for hands-on learning</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="{{ asset('images/welcome/teaching.jpg') }}" alt="Teaching">
                <div class="gallery-overlay">
                    <h3>Teachers</h3>
                    <p>Embracing students to grow and shape their futures/p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=600&h=400&fit=crop" alt="Student Activities">
                <div class="gallery-overlay">
                    <h3>Campus Life</h3>
                    <p>Vibrant student community with diverse activities and events</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="{{ asset('images/welcome/nursing.jpg') }}" alt="Lecture Hall">
                <div class="gallery-overlay">
                    <h3>High Passing Rate</h3>
                    <p>TCM serves Good Quality Education</p>
                </div>
            </div>

            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&h=400&fit=crop" alt="Campus Grounds">
                <div class="gallery-overlay">
                    <h3>Green Campus</h3>
                    <p>Beautiful outdoor spaces perfect for relaxation and study</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-text">
        © The College of Maasin 2025 | All Rights Reserved
    </div>

    <script>
        // Slideshow functionality
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.nav-dot');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            let currentSlide = 0;
            let slideInterval;

            // Function to show a specific slide
            function showSlide(n) {
                // Hide all slides
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));

                // Update current slide index
                currentSlide = (n + slides.length) % slides.length;

                // Show the current slide and activate corresponding dot
                slides[currentSlide].classList.add('active');
                dots[currentSlide].classList.add('active');
            }

            // Function to show next slide
            function nextSlide() {
                showSlide(currentSlide + 1);
            }

            // Function to show previous slide
            function prevSlide() {
                showSlide(currentSlide - 1);
            }

            // Start automatic slideshow
            function startSlideShow() {
                slideInterval = setInterval(nextSlide, 5000);
            }

            // Stop automatic slideshow
            function stopSlideShow() {
                clearInterval(slideInterval);
            }

            // Event listeners for navigation buttons
            nextBtn.addEventListener('click', () => {
                nextSlide();
                stopSlideShow();
                startSlideShow();
            });

            prevBtn.addEventListener('click', () => {
                prevSlide();
                stopSlideShow();
                startSlideShow();
            });

            // Event listeners for navigation dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    showSlide(index);
                    stopSlideShow();
                    startSlideShow();
                });
            });

            // Pause slideshow when hovering over it
            const slideshowContainer = document.querySelector('.slideshow-container');
            slideshowContainer.addEventListener('mouseenter', stopSlideShow);
            slideshowContainer.addEventListener('mouseleave', startSlideShow);

            // Initialize slideshow
            startSlideShow();
        });
    </script>
</body>
</html>
