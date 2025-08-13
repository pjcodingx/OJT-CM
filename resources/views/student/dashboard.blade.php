@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('styles')
<style>
        .info-card {
        flex: 1 1 180px;
        padding: 10px;
        min-height: 120px;
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
    }

    .card-link {
        font-size: 14px;
    }


    .summary-boxes {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .summary-box {
        flex: 1 1 220px;
        padding: 20px;
        border-radius: 10px;
        color: white;
        transition: transform 0.2s ease-in-out;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .summary-box:hover {
        transform: translateY(-5px);
    }

    .summary-box .title {
        font-size: 20px;
        font-weight: bold;
    }

    .summary-box .count {
        font-size: 36px;
        margin-top: 10px;
    }

    .summary-box .more-info {
        position: absolute;
        bottom: 15px;
        right: 20px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: underline;
        cursor: pointer;
    }

    .box-hours {
        background-color: #28a745;
    }

    .box-tasks {
        background-color: #ffc107;
        color: #000;
    }

    .box-journals {
        background-color: #dc3545;
    }

    h1{
        margin-top: -25px;
    }


    @media (max-width: 768px) {
    .card-title {
        font-size: 16px;
    }

    .card-number {
        font-size: 20px;
    }

    .card-link {
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .dashboard-title {
        font-size: 22px;
    }



    .card-title {
        font-size: 14px;
    }

    .card-number {
        font-size: 18px;
    }

    .card-link {
        font-size: 11px;
    }
}
</style>

@endsection


@section('content')

<div class="dashboard-content">
    <h1 class="dashboard-title">Dashboard</h1>


    <div class="info-cards">

        <div class="info-card green-card">
            <div class="card-content">
                <h3 class="card-title">OJT Hours Completed</h3>
                <div class="card-number">


                    @if ($student->hasCompletedOjt())
                        <span class="badge bg-green-600 text-white">Done OJT</span>
                    @else
                        <span>{{ $student->accumulated_hours }} / {{ $student->required_hours }}</span>
                    @endif
                    </div>
                <a href="{{ route('student.attendance.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>


        <div class="info-card yellow-card">
            <div class="card-content">
                <h3 class="card-title">Attendance Appeal</h3>
                <div class="card-number">{{ $appealsCount }}</div>
                <a href="{{ route('student.attendance-appeals.index') }}" class="card-link">View <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>


        <div class="info-card red-card">
            <div class="card-content">
                <h3 class="card-title">Journal Entries Submitted</h3>
                <div class="card-number">{{ $journalCount}}</div>
                <a href="{{ route('student.journals.index') }}" class="card-link">View Journals <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
    </div>
</div>

@endsection
