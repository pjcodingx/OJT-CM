@extends('layouts.student')

@section('content')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 30px;
        background-color: #1f2937;
        color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
    }

    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }

    .profile-header img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #107936;
        margin-right: 25px;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 26px;
    }

    .form-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        background-color: #374151;
        padding: 20px;
        border-radius: 10px;
    }

    .form-label {
        font-size: 14px;
        color: #9ca3af;
        margin-bottom: 8px;
        display: block;
    }

    .form-input {
        width: 100%;
        padding: 12px;
        background-color: #1f2937;
        border: 1px solid #4b5563;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        margin-top: 5px;
    }

    .form-input:focus {
        outline: none;
        border-color: #107936;
    }

    .upload-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #236425;
        color: #fff;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.4s;
        font-size: 14px;
        text-decoration: none;
        border: none;
    }

    .upload-btn:hover {
        background-color: #0b420e;
    }

    .btn-container {
        display: flex;
        gap: 10px;
        justify-content: flex-start;
        margin-top: 20px;
    }

    .btn-secondary {
        background-color: #6b7280;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    @media (max-width: 600px) {
        .profile-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .profile-header img {
            margin-bottom: 10px;
        }

        .btn-container {
            flex-direction: column;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <img src="{{ asset('uploads/student_photos/' . ($student->photo ?? 'default.png')) }}" alt="Profile Photo" class="profile-img">
        <h2>Change Password</h2>
    </div>

    @if(session('success'))
        <div style="background-color: #10b981; color: white; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background-color: #ef4444; color: white; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('student.update.password', $student->id) }}" method="POST">
        @csrf

        <div class="form-container">
            <div class="form-group">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-input" required minlength="8">
            </div>

            <div class="form-group">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-input" required minlength="8">
            </div>
        </div>

        <div class="btn-container">
            <button type="submit" class="upload-btn">Update Password</button>
            <a href="{{ route('student.profile') }}" class="upload-btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
