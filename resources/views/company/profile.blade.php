@extends('layouts.company')

@section('content')
<style>
    .profile-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 30px;
        background-color: #1f2937;
        color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .profile-header {
        margin-bottom: 25px;
        text-align: center;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: bold;
        color: #4ade80;
    }

    .profile-photo-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-photo-container img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #107936;
        margin-bottom: 10px;
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
        margin-top: -20px;
        margin-bottom: 10px;
        transition: 0.4s;
        font-size: 14px;
    }

    .upload-btn:hover {
        background-color: #0b420e;
    }

    .profile-details {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .detail-box {
        flex: 1 1 45%;
        background-color: #374151;
        padding: 20px;
        border-radius: 10px;
        box-shadow: inset 0 0 10px #107936aa;
    }

    .detail-label {
        font-size: 14px;
        color: #9ca3af;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .detail-value {
        font-size: 18px;
        color: #fff;
        font-weight: 600;
    }

    @media (max-width: 600px) {
        .detail-box {
            flex: 1 1 100%;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <h2>{{ $company->name }}</h2>
    </div>

    <div class="profile-photo-container">
        <img src="{{ asset('uploads/company_photos/' . ($company->photo ?? 'default.png')) }}" alt="Company Photo">
    </div>

    <form id="photoForm" action="{{ route('company.update.photo', $company->id) }}" method="POST" enctype="multipart/form-data" style="text-align: center; margin-bottom: 20px;">
        @csrf
        <input type="file" name="photo" id="photo" accept="image/*" class="upload-hidden" onchange="document.getElementById('photoForm').submit();">
        <label for="photo" class="upload-btn">Upload Photo</label>

        <div style="text-align: center; margin-bottom: 20px;">
            <a href="{{ route('company.change.password') }}" class="upload-btn" style="text-decoration: none;">
                Change Password
            </a>
</div>
    </form>

    <div class="profile-details">
        <div class="detail-box">
            <div class="detail-label">Email</div>
            <div class="detail-value">{{ $company->email }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Address</div>
            <div class="detail-value">{{ $company->address ?? 'N/A' }}</div>
        </div>

        <div class="detail-box">
            <div class="detail-label">Total Assigned Students</div>
            <div class="detail-value">{{ $studentsCount }}</div>
        </div>


    </div>
</div>
@endsection
