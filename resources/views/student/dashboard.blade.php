@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('styles')
<style>
    .dashboard-title {
        color: #2c3e50;
        margin-top: 10px;
        margin-bottom: 30px;
        font-weight: 600;
    }

    .info-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 24px;
    }

    .info-card {
        background-color: #ffffff;
        padding: 24px;
        border-radius: 16px;
        color: #2c3e50;
        min-height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow:
            0 4px 8px rgba(0, 0, 0, 0.05),
            0 6px 20px rgba(0, 0, 0, 0.05),
            inset 0 0 0 1px rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow:
            0 12px 28px rgba(0, 0, 0, 0.1),
            0 8px 12px rgba(0, 0, 0, 0.08),
            inset 0 0 0 1px rgba(255, 255, 255, 0.9);
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(to right, #205501, #16d105);
        z-index: 1;
        border-radius: 16px 16px 0 0;
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #5a6978;
        position: relative;
        z-index: 2;
    }

    .card-number {
        font-size: 36px;
        font-weight: 800;
        margin: 10px 0;
        color: #2c3e50;
        position: relative;
        z-index: 2;
    }

    .badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 16px;
        font-weight: 600;
    }

    .bg-green-600 {
        background-color: #27ae60;
        color: white;
    }

    .card-link {
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        margin-top: 15px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        color: #7f8c8d;
        position: relative;
        z-index: 2;
        transition: all 0.2s ease;
    }

    .card-link i {
        transition: transform 0.2s ease;
        margin-left: 5px;
        font-size: 12px;
    }

    .card-link:hover {
        color: #2c3e50;
    }

    .card-link:hover i {
        transform: translateX(3px);
    }

    .card-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 28px;
        opacity: 0.1;
        z-index: 1;
        color: #2c3e50;
    }

    .card-bg-pattern {
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 120px;
        height: 120px;
        opacity: 0.03;
        z-index: 0;
        background: radial-gradient(circle, #7f8c8d 0%, transparent 70%);
    }

    @media (max-width: 768px) {
        .info-card {
            min-height: 160px;
            padding: 20px;
        }

        .dashboard-title {
            font-size: 22px;
        }

        .card-title {
            font-size: 16px;
        }

        .card-number {
            font-size: 30px;
        }

        .card-link {
            font-size: 13px;
        }

        .card-icon {
            font-size: 24px;
        }

        .badge {
            font-size: 14px;
            padding: 6px 12px;
        }
    }

    @media (max-width: 480px) {
        .info-cards {
            grid-template-columns: 1fr;
        }

        .card-title {
            font-size: 14px;
        }

        .card-number {
            font-size: 26px;
        }

        .card-link {
            font-size: 12px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    @php
        $hour = now()->format('H');
        if ($hour < 12) {
            $greeting = 'Good Morning';
        } elseif ($hour < 18) {
            $greeting = 'Good Afternoon';
        } else {
            $greeting = 'Good Evening';
        }
    @endphp
    <h1 class="dashboard-title">{{ $greeting }}, {{ $student->name }}</h1>

    <div class="info-cards">
        <div class="info-card">
            <i class="fas fa-clock card-icon"></i>
            <div class="card-bg-pattern"></div>
            <h3 class="card-title">OJT Hours Completed</h3>
            <div class="card-number">
                @if ($student->hasCompletedOjt())
                    <span class="badge bg-green-600">Done OJT</span>
                @else
                    <span>{{ $student->accumulated_hours }} / {{ $student->required_hours }}</span>
                @endif
            </div>
            <a href="{{ route('student.attendance.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
        </div>

        <div class="info-card">
            <i class="fas fa-exclamation-circle card-icon"></i>
            <div class="card-bg-pattern"></div>
            <h3 class="card-title">Attendance Appeal</h3>
            <div class="card-number">{{ $appealsCount }}</div>
            <a href="{{ route('student.attendance-appeals.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
        </div>

        <div class="info-card">
            <i class="fas fa-book card-icon"></i>
            <div class="card-bg-pattern"></div>
            <h3 class="card-title">Journals Submitted</h3>
            <div class="card-number">{{ $journalCount}}</div>
            <a href="{{ route('student.journals.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</div>
@endsection
