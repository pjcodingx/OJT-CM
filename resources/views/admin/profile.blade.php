@extends('layouts.admin')

@section('title', 'Admin Profile')






@section('content')

<style>
    .profile-container {
        max-width: 600px;
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
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #107936;
        margin-right: 25px;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 24px;
    }

    .profile-details {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .detail-box {
        background-color: #374151;
        padding: 15px;
        border-radius: 10px;
    }

    .detail-label {
        font-size: 14px;
        color: #9ca3af;
    }

    .detail-value input {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .upload-hidden {
        display: none;
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
        margin-top: 10px;
    }

    .upload-btn:hover {
        background-color: #0b420e;
    }

    .save-btn {
        margin-top: 20px;
        background-color: #4ade80;
        color: #000;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .save-btn:hover {
        background-color: #22c55e;
    }
</style>

@if($errors->any())
<div style="background-color: #ef4444; color: white; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
    @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif

@if(session('success'))
<div style="background-color: #4ade80; color: black; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
    {{ session('success') }}
</div>
@endif

<div class="profile-container">
    <div class="profile-header">
        <img src="{{ asset('uploads/admin_photos/' . ($admin->photo ?? 'default.png')) }}" alt="Profile Photo" id="previewPhoto">
        <h2>{{ $admin->name }}</h2>
    </div>

    <!-- Unified Form: Name, Password, Photo -->
    <form action="{{ route('admin.profile.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="profile-details">

            <div class="detail-box">
                <div class="detail-label">Profile Photo</div>
                <input type="file" name="photo" id="photo" class="upload-hidden" accept="image/*" onchange="previewImage(event)">
                <label for="photo" class="upload-btn">Choose Photo</label>
            </div>

            <div class="detail-box">
                <div class="detail-label">Name</div>
                <div class="detail-value">
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" required>
                </div>
            </div>

            <div class="detail-box">
                <div class="detail-label">New Password</div>
                <div class="detail-value">
                    <input type="password" name="password" placeholder="Enter new password">
                </div>
            </div>

            <div class="detail-box">
                <div class="detail-label">Confirm Password</div>
                <div class="detail-value">
                    <input type="password" name="password_confirmation" placeholder="Confirm new password">
                </div>
            </div>

            <button type="submit" class="save-btn">Save Changes</button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('previewPhoto');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
