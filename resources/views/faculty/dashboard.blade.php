@extends('layouts.faculty')

@section('content')

<style>
.dashboard-title {
        color: #043306;
        margin-top: -30px;
        margin-bottom: 50px;
    }

    .info-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .info-card {
        flex: 1 1 220px;
        background-color: #1f1f1f;
        padding: 20px;
        border-radius: 10px;
        color: white;
        transition: transform 0.2s ease-in-out;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
    }

    .card-title {
        font-size: 20px;
        font-weight: bold;
    }

    .card-number {
        font-size: 30px;
        margin-top: 10px;
    }

    .card-link {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        margin-top: 10px;
        display: inline-block;
    }

    .green-card {
        background-color: #28a745;
    }

    .yellow-card {
        background-color: #ffc107;
        color: #000;
    }

    .red-card {
        background-color: #dc3545;
    }

    @media (max-width: 768px) {
        .card-title { font-size: 16px; }
        .card-number { font-size: 20px; }
        .card-link { font-size: 12px; }
    }

    @media (max-width: 480px) {
        .dashboard-title { font-size: 22px; }
        .card-title { font-size: 14px; }
        .card-number { font-size: 18px; }
        .card-link { font-size: 11px; }
    }
</style>

<div class="dashboard-content">
    <h1 class="dashboard-title">Faculty Overview</h1>


    <div class="info-cards">

        <div class="info-card green-card">
            <div class="card-content">
                <h3 class="card-title">Total Trainees</h3>
                <div class="card-number">{{$totalStudents}}</div>
                <a href="{{ route('faculty.students.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>


        <div class="info-card yellow-card">
            <div class="card-content">
                <h3 class="card-title">Journal Submissions</h3>
                <div class="card-number">{{ $journalCount }}</div>
                <a href="{{ route('faculty.journals.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>


        <div class="info-card red-card">
            <div class="card-content">
                <h3 class="card-title">Company Feedbacks</h3>
                <div class="card-number">{{ $feedbackTotal}}</div>
                <a href="{{ route('faculty.feedbacks.index') }}" class="card-link">View All <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>


    </div>
</div>




@endsection
