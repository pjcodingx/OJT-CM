@extends('layouts.admin')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #222;
    }

    .container {
        max-width: 800px;
        margin: 30px auto;
        background: #fff;
        padding: 25px 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 100, 0, 0.1);
    }

    h2 {
        color: #064d1c;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: #064d1c;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #ccc;
        border-radius: 5px;
        transition: 0.3s;
        font-size: 14px;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #064d1c;
        box-shadow: 0 0 5px rgba(6, 77, 28, 0.5);
        background-color: #f2fdf4;
    }

    .password-row {
    display: flex;
    gap: 20px;
}

.password-wrapper {
    flex: 1;
    position: relative;
    display: flex;
    flex-direction: column;
}

.password-wrapper input {
    width: 100%;
    padding: 10px 35px 10px 12px; /* space for the eye icon */
    font-size: 14px;
    border: 2px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.password-wrapper label {
    margin-bottom: 8px;
    font-weight: bold;
    color: #064d1c;
}

.toggle-password {
    position: absolute;
    top: 38px; /* push icon down to align inside input */
    right: 12px;
    cursor: pointer;
    font-size: 18px;
    color: #666;
    z-index: 1;
}




    button{
         background-color: #064d1c;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 15px;
        border-radius: 5px;
        cursor: pointer;
        display: block;
        margin: 0 0;
        transition: background-color 0.3s ease;
    }



    small {
        display: block;
        margin-top: 5px;
        color: #666;
    }

 input[type="password"]::-ms-reveal {
                display: none;
            }


</style>



<div class="container">
    <h2>Create New Adviser</h2>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.faculties.store') }}" method="POST" onsubmit="return validatePasswords()">
        @csrf

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group password-row">
        <div class="password-wrapper">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">👁</span>
        </div>

        <div class="password-wrapper">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            {{-- <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">👁</span> --}}
        </div>

</div>
 <small id="password-match-message" style="color: red; display: none; margin-top: -15px; margin-bottom: 7px;">Passwords do not match</small>


       <div class="form-group">
        <label for="course_id">Course</label>
        <select name="course_id" id="course_id" class="form-control" required>
            <option value="">-- Select Course --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>
    </div>

        <button type="submit">Create Adviser</button>
    </form>
</div>

<script>
    function togglePassword(id, el) {
        const input = document.getElementById(id);
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        el.textContent = type === 'password' ? '👁' : '👁';
    }

    function validatePasswords() {
        const p1 = document.getElementById('password').value;
        const p2 = document.getElementById('password_confirmation').value;
        if (p1 !== p2) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }

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
