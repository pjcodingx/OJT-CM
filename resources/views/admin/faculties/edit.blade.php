@extends('layouts.admin')

@section('styles')
<style>
    body {
        background-color: #f0fdf4;
        color: #1b4332;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2 {
        color: #1b4332;
        font-size: 32px;
        margin-bottom: 25px;
        text-align: center;
    }

    .student-create-form {
        background-color: white;
        border-radius: 12px;
        padding: 40px;
        max-width: 900px;
        margin: 20px auto;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

     label {
        font-weight: 600;
        color: #1b4332;
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
        width: 100%;
        padding: 12px 15px;
        border-radius: 8px;
        border: 1.5px solid #ccc;
        background-color: #fff;
        color: #1b4332;
        font-size: 15px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    input:focus,
    select:focus {
        border-color: #2d6a4f;
        outline: none;
        box-shadow: 0 0 0 2px rgba(45, 106, 79, 0.3);
    }

    input::placeholder {
        color: #a0aec0;
    }

    .btn-submit {
        margin-top: 30px;
        text-align: center;
    }

    .btn-submit button {
        background-color: #2d6a4f;
        color: white;
        border: none;
        padding: 12px 32px;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-submit button:hover {
        background-color: #1b4332;
    }

    .alert-success,
    .alert-error {
        padding: 10px 15px;
        border-radius: 6px;
        margin-top: 20px;
        font-size: 15px;
        text-align: center;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .password-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .password-col {
        flex: 1 1 48%;
    }


    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
        color: #1b4332;
    }


    .input-icon {
        position: relative;
    }

    .input-icon input {
        padding-right: 40px;
    }


      .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-size: 0.95rem;
        font-weight: bold;
        color: #14532d; /* dark green heading */
    }

    .form-group select {
        width: 100%;
        padding: 10px 14px;
        font-size: 14px;
        background-color: #fff;
        color: #1f2937; /* gray-800 text */
        border: 2px solid #14532d; /* dark green border */
        border-radius: 8px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-group select:focus {
        outline: none;
        border-color: #166534; /* darker green on focus */
        box-shadow: 0 0 0 2px rgba(22, 101, 52, 0.25); /* soft focus ring */
    }

    .form-group select option {
        padding: 6px;
    }



    .company-multiselect {
    width: 100%;
    height: 120px; /* Allows multiple items to be visible */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    background-color: #fff;
    color: #333;
}
.company-multiselect:focus {
    outline: none;
    border-color: #006400; /* dark green */
    box-shadow: 0 0 0 2px rgba(0, 100, 0, 0.3);
}

</style>
@endsection

@section('content')
<div class="student-create-form">
    <h2>Edit OJT Adviser</h2>

    <form action="{{ route('admin.faculties.update', $faculty->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $faculty->name }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $faculty->email }}" required>
        </div>

        <div class="form-row" style="display: flex; gap: 30px; margin-bottom: 8px;">
    <!-- New Password -->
            <div class="form-group password-wrapper" style="flex: 1;">
                <label for="password">New Password</label>
                <div class="input-icon">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password">
                    <button type="button" class="toggle-password" data-target="password">👁</button>
                </div>
            </div>

    <!-- Confirm Password -->
        <div class="form-group password-wrapper" style="flex: 1;">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-icon">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password">
                    {{-- <button type="button" class="toggle-password" data-target="password_confirmation">👁</button> --}}
                </div>
                <small id="password-match-message" style="color: red; display: none;">Passwords do not match</small>
            </div>
        </div>



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
            <label>Department (Course)</label>
            <select name="course_id" required>
                <option value="">-- Select Department --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}"
                        {{ old('course_id', $faculty->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
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
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', () => {
            const target = document.getElementById(button.dataset.target);
            target.type = target.type === 'password' ? 'text' : 'password';
        });
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
