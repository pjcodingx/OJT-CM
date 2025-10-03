@extends('layouts.faculty')

@section('styles')
<style>
    .student-create-form {
        max-width: 900px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        font-family: Verdana, sans-serif;
    }

    .student-create-form h2 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #006400;
        text-align: center;
    }

    .student-create-form .form-group {
        margin-bottom: 20px;
    }

    .student-create-form label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #333;
    }

     input[type="password"]::-ms-reveal {
                display: none;
            }

    .student-create-form input,
    .student-create-form select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-family: Verdana, sans-serif;
    }

    .student-create-form input:focus,
    .student-create-form select:focus {
        border-color: #006400;
        outline: none;
    }

    .student-create-form button[type="submit"] {
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

    .student-create-form button[type="submit"]:hover {
        background-color: #004d00;
        padding: 10px 18px;
    }

    .student-create-form .input-wrapper {
        position: relative;
        width: 100%;
    }

    .student-create-form .input-field {
        width: 100%;
        padding: 10px 40px 10px 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-family: Verdana, sans-serif;
    }

    .student-create-form .toggle-password {
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

    .alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 12px 20px;
    border-radius: 5px;
    margin-bottom: 20px;
    font-size: 14px;
    font-family: Verdana, sans-serif;
    transition: opacity 0.5s ease-out;
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

.password-col .input-wrapper {
    position: relative;
}

.password-error {
    color: red;
    font-size: 13px;
    margin-top: 5px;
    display: none;
    font-family: Verdana, sans-serif;
}

 .alert-error {
        display: none;
        background-color: #fee2e2;
        color: #b91c1c;
        padding: 10px 15px;
        border-left: 5px solid #dc2626;
        border-radius: 4px;
        margin-top: 10px;
        font-size: 14px;
    }

    @media (max-width: 640px) {
        .alert-error {
            font-size: 13px;
            padding: 8px 12px;
        }
    }


</style>
@endsection

@section('content')
<div class="student-create-form">
    <h2>Create Student Account</h2>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

    <form action="{{ route('faculty.manage-students.store') }}" method="POST" id="create-student-form">
        @csrf

        @if ($errors->any())
            <div class="alert-error" style="display: block; background-color: #fee2e2; color: #b91c1c; padding: 10px 15px; border-left: 5px solid #dc2626; border-radius: 4px; margin-bottom: 15px;">
                <ul style="margin:0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="password-row">

        <div class="form-group password-col">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrapper">
                <input type="password" id="password" name="password" class="input-field" required>
                <button type="button" class="toggle-password" onclick="toggleVisibility('password', this)">👁</button>
            </div>
        </div>


        <div class="form-group password-col">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-wrapper">
                <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" required>
                {{-- <button type="button" class="toggle-password" onclick="toggleVisibility('password_confirmation', this)">👁</button> --}}

            </div>
        </div>


    </div>

    <small id="password-match-message" style="color: red; display: none; margin-top: -10px; margin-bottom: 5px;">Passwords do not match</small>


    <p id="password-error" class="alert-error">⚠️ Passwords do not match.</p>


        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id" id="course_id" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Assign Company</label>
            <select name="company_id">
                <option value="">-- None --</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- <div class="form-group">
            <label>Assign Adviser</label>
            <select name="faculty_id">
                <option value="">-- None --</option>
                @foreach ($faculties as $faculty)
                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                @endforeach
            </select>
        </div> --}}

        <div class="form-group">
            <label>Required OJT Hours</label>
            <input type="number" name="required_hours" min="1" required>
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

    document.addEventListener('DOMContentLoaded', function () {
        const alertBox = document.querySelector('.alert-success');
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 500);
            }, 3000);
        }
    });

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


     const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const message = document.getElementById('password-match-message');

    function checkMatch() {
        if (password.value && confirm.value && password.value !== confirm.value) {
            message.style.display = 'block';
        } else {
            message.style.display = 'none';
        }
    }

    password.addEventListener('input', checkMatch);
    confirm.addEventListener('input', checkMatch);
</script>
@endsection
