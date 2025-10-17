@extends('layouts.faculty')

@section('styles')
<style>
    .company-create-form {
        max-width: 900px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        font-family: Verdana, sans-serif;
    }

    .company-create-form h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #006400;
        text-align: center;
    }

    .company-create-form .form-group {
        margin-bottom: 20px;
    }

    .company-create-form label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #333;
    }

    .company-create-form input {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-family: Verdana, sans-serif;
    }

    .company-create-form input:focus {
        border-color: #006400;
        outline: none;
    }

    .company-create-form button[type="submit"] {
        background-color: #044d04;
        color: white;
        padding: 10px 16px;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 20px auto 0;
        display: block;
        width: 200px;
        font-family: Verdana, sans-serif;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .company-create-form button[type="submit"]:hover {
        background-color: #004d00;
        padding: 10px 18px;
    }

    .input-wrapper {
        position: relative;
        width: 100%;
    }

    .input-field {
        width: 100%;
        padding: 10px 40px 10px 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-family: Verdana, sans-serif;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        border: none;
        background: none;
        font-size: 16px;
        color: #555;
    }

    .password-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .password-col {
        flex: 1;
        min-width: 250px;
    }

    .alert {
    position: fixed;
    top: 90px;
    right: 40px;
    padding: 14px 22px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 14px;
    color: #fff;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    animation: slideIn 0.5s ease, fadeOut 0.5s ease 4s forwards;
}

/* Success (your green tone) */
.success-alert {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

/* Info (blue) */
.info-alert {
    background: #eff6ff;
    color: #1e3a8a;
    border: 1px solid #bfdbfe;
}

/* Error (red) */
.error-alert {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

@keyframes slideIn {
    from {
        transform: translateX(120%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateX(120%);
    }
}

 input[type="password"]::-ms-reveal {
                display: none;
            }
</style>
@endsection

@section('content')
<div class="company-create-form">
    <h2>Create Company</h2>
        @if (session('success'))
            <div class="alert success-alert">
                {{ session('success') }}
            </div>
        @endif
    <form action="{{ route('faculty.manage-companies.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required>
        </div>

        <div class="password-row">
            <div class="form-group password-col">
                <label>Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" class="input-field" required>
                    <button type="button" class="toggle-password" onclick="toggleVisibility('password', this)">👁</button>
                </div>
            </div>

            <div class="form-group password-col">
                <label>Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" required>
                    {{-- <button type="button" class="toggle-password" onclick="toggleVisibility('password_confirmation', this)">👁</button> --}}
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address">
        </div>

        <button type="submit">Create</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleVisibility(id, el) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            el.textContent = '👁';
        } else {
            input.type = 'password';
            el.textContent = '👁';
        }
    }

      document.getElementById('create-student-form').addEventListener('submit', function (e) {
        const pass = document.getElementById('password');
        const confirm = document.getElementById('password_confirmation');
        const errorMsg = document.getElementById('password-error');
        const alertBox = document.querySelector('.alert-error');

        if (pass.value !== confirm.value) {
            e.preventDefault();
            errorMsg.style.display = 'block';
            confirm.focus();
        } else {
            errorMsg.style.display = 'none';
        }

        if (alertBox) {
            setTimeout(() => {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500);
            }, 3000);
        }
    });
</script>
@endsection
