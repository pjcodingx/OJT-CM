@extends('layouts.faculty')

@section('styles')
<style>
    /* Reusing styles from create */
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

    .form-group { margin-bottom: 20px; }
    .form-group label { font-weight: bold; color: #333; margin-bottom: 6px; display: block; }
    .form-group input, .form-group select {
        width: 100%; padding: 10px; font-size: 14px;
        border: 1px solid #ccc; border-radius: 4px;
        font-family: Verdana, sans-serif; box-sizing: border-box;
    }
    .form-group input:focus, .form-group select:focus {
        border-color: #006400; outline: none;
    }

    .password-row { display: flex; gap: 20px; flex-wrap: wrap; }
    .password-col { flex: 1; min-width: 250px; }

    .input-wrapper { position: relative; width: 100%; }
    .toggle-password {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        border: none; background: none; font-size: 16px; cursor: pointer; color: #555;
    }

    .qr-display img {
        border: 1px solid #ccc; border-radius: 6px;
        width: 120px; height: 120px; object-fit: contain;
    }

    .btn-submit button {
        background-color: #044d04; color: white;
        padding: 10px 16px; font-size: 16px; font-weight: 600;
        border: none; border-radius: 4px; cursor: pointer;
        width: 200px; margin: 20px auto 0; display: block;
        transition: background-color 0.3s ease;
    }
    .btn-submit button:hover { background-color: #004d00; }

    .checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
}

.checkbox-wrapper input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #006400; /* dark green */
}

.checkbox-wrapper label {
    margin: 0;
    font-weight: 500;
}

.alert-error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 12px 20px;
    border-radius: 5px;
    margin-bottom: 20px;
    font-size: 14px;
    font-family: Verdana, sans-serif;
    transition: opacity 0.5s ease-out;
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


</style>
@endsection

@section('content')
    <div class="student-create-form">
        <h2>Edit Student</h2>

        <form action="{{ route('faculty.manage-students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{ $student->name }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $student->email }}" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" value="{{ old('username', $student->username) }}" required>
            </div>


            <div class="password-row">
                <div class="form-group password-col">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" class="input-field">
                        <button type="button" class="toggle-password" onclick="toggleVisibility('password', this)">👁</button>
                    </div>
                </div>




                <div class="form-group password-col">
                    <label>Confirm Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="input-field">
                    </div>
                </div>
            </div>

            <small id="password-match-message" style="color: red; display: none; margin-top: -10px; margin-bottom: 5px;">Passwords do not match</small>

             @if ($errors->any())
                <div id="errorBox" class="alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label>Course</label>
                <select name="course_id" required>
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $student->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Assign Company</label>
                <select name="company_id">
                    <option value="">-- None --</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ $student->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label>Required OJT Hours</label>
                <input type="number" name="required_hours" value="{{ $student->required_hours }}" min="1" required>
            </div>

            <div class="form-group">
                <label>QR Code</label><br>
                @if ($student->qr_code_path)
                    <img src="{{ asset('storage/' . $student->qr_code_path) }}" alt="QR Code">
                @else
                    <span style="color: red;">No QR Code</span>
                @endif
            </div>

            <div class="checkbox-wrapper">
                <input type="hidden" name="regenerate_qr" value="0">
                <input type="checkbox" name="regenerate_qr" id="regenerate_qr" value="1" {{ old('regenerate_qr') ? 'checked' : '' }}>
                <label for="regenerate_qr">Generate QR Code</label>

            </div>

            @if(session('success'))
                <div id="alertBox" class="alert-success">
                    {{ session('success') }}
                </div>
            @endif



            <div class="btn-submit">
                    <button type="submit">Update</button>
                </div>
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
        const alertBox = document.getElementById('alertBox');
        const errorBox = document.getElementById('errorBox');

        if (alertBox) {
            setTimeout(() => {
                alertBox.style.opacity = '0';
                setTimeout(() => alertBox.remove(), 300);
            }, 3000);
        }

        if (errorBox) {
            setTimeout(() => {
                errorBox.style.opacity = '0';
                setTimeout(() => errorBox.remove(), 300);
            }, 5000);
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
