@extends('layouts.faculty')

@section('content')
<style>
    /* Reuse your same profile styles */
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
    .profile-header h2 { margin: 0; font-size: 26px; }
    .profile-details { display: flex; flex-wrap: wrap; gap: 20px; }
    .detail-box { flex: 1 1 45%; background-color: #374151; padding: 15px; border-radius: 10px; }
    .detail-label { font-size: 14px; color: #9ca3af; }
    .detail-value { font-size: 16px; margin-top: 5px; color: #fff; }
    .upload-hidden { display: none; }
    .upload-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #236425;
        color: #fff;
        border-radius: 8px;
        cursor: pointer;
        margin-top: -20px;
        margin-bottom: 10px;
        transition: 0.4s;
        font-size: 14px;
    }
    .upload-btn:hover { background-color: #0b420e; }
</style>

<div class="profile-container">
    <div class="profile-header">
        <img src="{{ asset('uploads/faculty_photos/' . ($faculty->photo ?? 'default.png')) }}" alt="Profile Photo">
        <h2>{{ $faculty->name }}</h2>
    </div>

    <form id="photoForm" action="{{ route('faculty.update.photo', $faculty->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; gap: 10px; align-items: center;">
        @csrf
        <input type="file" name="photo" id="photo" accept="image/*" class="upload-hidden" onchange="document.getElementById('photoForm').submit();">

        <label for="photo" class="upload-btn">Upload photo</label>

        <a href="{{ route('faculty.change-password') }}" class="upload-btn" style="text-decoration: none;">
            Change Password
        </a>
    </form>

    <div class="profile-details">
        <div class="detail-box">
            <div class="detail-label">Email</div>
            <div class="detail-value">{{ $faculty->email }}</div>
        </div>
        <div class="detail-box">
            <div class="detail-label">Department</div>
            <div class="detail-value">{{ $faculty->course->name ?? 'N/A' }}</div>
        </div>
        <div class="detail-box">
            <div class="detail-label">Assigned Students</div>
            <div class="detail-value">{{ $faculty->students->count() }}</div>
        </div>
        <div class="detail-box">
            <div class="detail-label">Partnered Companies</div>
            <div class="detail-value">{{ $faculty->companies->count() }}</div>
        </div>
    </div>
</div>
@endsection
