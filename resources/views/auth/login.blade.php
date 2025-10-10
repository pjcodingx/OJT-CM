
<!--- THIS IS MY LOGIN PAGE FOR THE SCHOOL PORTAL --->

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>School Login Portal</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="icon" sizes="32x32" href="{{ asset('favicon/cmlogo.png') }}" type="image/png">
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                min-height: 100vh;
                background: #FFF;
                background: linear-gradient(90deg,
                    white 0%,
                    rgba(87, 199, 133, 1) 63%,
                    rgba(117, 117, 117, 1) 100%
                );
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
            }

          .logo-overlay {
                position: absolute;
                left: -200px;
                top: 50%;
                transform: translateY(-50%);
                width: 950px;
                height: 950px;
                opacity: 0.1;
                z-index: 1;
                pointer-events: none;
            }

            .logo-overlay img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .login-container {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 16px;
                padding: 3rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
                z-index: 2;
                position: relative;
            }

            .login-header {
                text-align: center;
                margin-bottom: 2rem;
            }

            .login-header h1 {
                color: #2d3748;
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .login-header p {
                color: #718096;
                font-size: 1rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                color: #4a5568;
                font-weight: 500;
                font-size: 0.875rem;
            }

            .form-group input {
                width: 100%;
                padding: 0.875rem 1rem;
                border: 2px solid #e2e8f0;
                border-radius: 8px;
                font-size: 1rem;
                transition: all 0.2s ease;
                background: white;
            }

            .form-group input:focus {
                outline: none;
                border-color: rgba(87, 199, 133, 0.8);
                box-shadow: 0 0 0 3px rgba(87, 199, 133, 0.1);
            }

            .form-group input::placeholder {
                color: #a0aec0;
            }

            .submit-button {
                width: 100%;
                background: linear-gradient(135deg, rgba(87, 199, 133, 1) 0%, rgba(67, 179, 113, 1) 100%);
                color: white;
                border: none;
                padding: 1rem;
                border-radius: 8px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s ease;
                margin-top: 0.5rem;
            }

            .submit-button:hover {
                transform: translateY(-1px);
                box-shadow: 0 10px 20px rgba(87, 199, 133, 0.3);
            }

            .submit-button:active {
                transform: translateY(0);
            }

            .forgot-password {
                text-align: center;
                margin-top: 1.5rem;
            }

            .forgot-password a {
                color: rgba(87, 199, 133, 1);
                text-decoration: none;
                font-size: 0.875rem;
                font-weight: 500;
            }

            .forgot-password a:hover {
                text-decoration: underline;
            }

            @media (max-width: 1318px){
                .logo-overlay {
                position: absolute;
                left: -150px;
                top: 50%;
                transform: translateY(-50%);
                width: 800px;
                height: 800px;
                opacity: 0.1;
                z-index: 1;
                pointer-events: none;
            }
            }



            @media (max-width: 768px) {
                .login-container {
                    margin: 1rem;
                    padding: 2rem;
                }

                .logo-overlay {
                    width: 200px;
                    height: 200px;
                    left: -180px;
                }

                .login-header h1 {
                    font-size: 1.75rem;
                }
            }

            @media (max-width: 1200px) {
                .login-container {
                    margin: 1rem;
                    padding: 2rem;
                }
                .logo-overlay img{
                    width: 500px;
                }

                .logo-overlay {
                    width: 200px;
                    height: 200px;
                    left: -180px;
                }

                .login-header h1 {
                    font-size: 1.75rem;
                }
            }

            @media (max-width: 480px) {
                .login-container {
                    padding: 1.5rem;
                }

                .logo-overlay {
                    width: 180px;
                    height: 180px;
                    left: -80px;
                    opacity: 0.08;
                }
            }

            /* Extra small phones */
            @media (max-width: 460px) {
                .logo-overlay {
                    width: 300px;
                    height: 300px;
                    left: -30px;
                    opacity: 0.06;
                }
            }


            .sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                padding: 0;
                margin: -1px;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            }

            input[type="password"]::-ms-reveal {
                display: none;
            }
        </style>
    </head>
    <body>
        <!-- CM School Logo Overlay -->
        <div class="logo-overlay" aria-hidden="true">
            <img src="{{ asset('images/cmlogo.png') }}" alt="School Logo"/>
        </div>

        <!-- This is Cm Login Form Container -->
        <main class="login-container">
            <header class="login-header">
                <h1>Welcome Back!</h1>
                <p style="font-size: 14px; margin-top: -8px;">Please sign in to your account</p>
            </header>

            @if ($errors->any())
            <div id="error-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="text-sm list-disc list-inside" style="list-style: none">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form action="{{ route('multi.login') }}" method="post" novalidate>
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Enter your Username"
                        required
                        autocomplete="username"
                    />
                </div>

                <div class="form-group relative">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"

                        class="w-full pr-10"
                    />


                    <i id="togglePassword"
                    class="fa-solid fa-eye absolute right-3 top-[48px] text-gray-500 cursor-pointer">
                    </i>



                </div>

                <button type="submit" class="submit-button">
                    Sign In
                </button>

                <div class="forgot-password">
                    <p style="color: #718096; font-size: 0.875rem; font-weight: 500;">Forgot your password? Contact Admin</p>
                </div>
            </form>
        </main>

        <div class="sr-only">
            <p>This is the school login portal. Please enter your credentials to access your account.</p>
        </div>



        <!-----THIS IS MY SCRIPT------->

        <script>
            setTimeout(() => {
                const errorBox = document.getElementById('error-message');
                if (errorBox) {
                    errorBox.style.transition = 'opacity 0.5s ease';
                    errorBox.style.opacity = '0';


                    setTimeout(() => {
                        errorBox.remove();
                    }, 500);
                }
                    }, 2500);


                    const toggle = document.getElementById('togglePassword');
                    const password = document.getElementById('password');

                    toggle.addEventListener('click', () => {
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);

                        // Toggle icon style
                        toggle.classList.toggle('fa-eye');
                        toggle.classList.toggle('fa-eye-slash');
                    });



        </script>



    </body>
    </html>
