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

        .profile-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .detail-box {
            flex: 1 1 45%;
            background-color: #374151;
            padding: 15px;
            border-radius: 10px;
        }

        .detail-label {
            font-size: 14px;
            color: #9ca3af;
        }

        .detail-value {
            font-size: 16px;
            margin-top: 5px;
            color: #fff;
        }

        .qr-section {
            text-align: center;
            margin-top: 40px;
        }

        .qr-section img {
            width: 200px;
            height: 200px;
        }

        .download-btn {
            margin-top: 15px;
            background-color: #4ade80;
            color: #000;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .download-btn:hover {
            background-color: #22c55e;
        }

        @media (max-width: 600px) {
            .detail-box {
                flex: 1 1 100%;
            }

            .profile-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .profile-header img {
                margin-bottom: 10px;
            }
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





    </style>

    <div class="profile-container">
        <div class="profile-header">
        <img src="{{ asset('uploads/student_photos/' . ($student->photo ?? 'default.png')) }}" alt="Profile Photo" class="profile-img">

            <h2>{{ $student->name }}</h2>
        </div>

        <form id="photoForm" action="{{ route('student.update.photo', $student->id) }}}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="photo" id="photo" accept="image/*" class="upload-hidden" onchange="document.getElementById('photoForm').submit();">

            <label for="photo" class="upload-btn">Upload photo</label>
        </form>


        <div class="profile-details">
            <div class="detail-box">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $student->email }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Course</div>
                <div class="detail-value">{{ $student->course->name }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Company</div>
                <div class="detail-value">{{ $student->company->name ?? 'N/A' }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label">Company Location</div>
                <div class="detail-value">{{ $student->company->address ?? 'N/A' }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label">OJT Adviser</div>
                <div class="detail-value">{{ $student->faculty->name ?? 'N/A' }}</div>
            </div>
            <div class="detail-box">  {{--  will add the remaining hours here --}}
                <div class="detail-label">Required OJT Hours</div>
                <div class="detail-value">{{ $student->required_hours }} hours</div>
            </div>
        </div>

        <div class="qr-section">
            <h3 style="margin-bottom: 10px;">Student QR Code</h3>
            @if($student->qr_code_path)
            <a href="{{ asset('storage/' . $student->qr_code_path) }}" target="_blank">
                <img src="{{ asset('storage/' . $student->qr_code_path) }}"
                                    alt="QR Code"
                                    width="60"
                                    height="60"
                                    style="cursor: zoom-in; border: 1px solid #ccc;">
                <br>
            </a>
            <a href="{{ asset('storage/' . $student->qr_code_path) }}" download>
                            <button class="download-btn">Download</button>
                        </a>
            @else
            <span style="color: red;">No QR Code Available, Contact Admin</span>
            @endif
        </div>
    </div>
    @endsection
