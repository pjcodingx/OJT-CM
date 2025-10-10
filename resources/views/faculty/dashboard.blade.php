@extends('layouts.faculty')

@section('content')

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

.progress-bar {
    background-color: #e0e0e0;
    border-radius: 12px;
    overflow: hidden;
    height: 20px;
    margin: 15px 0;
    position: relative;
    z-index: 2;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(to right, #205501, #16d105);
    text-align: center;
    color: white;
    font-weight: bold;
    line-height: 20px;
    font-size: 12px;
}

.attendance-breakdown {
    font-size: 13px;
    margin-top: 5px;
    color: #5a6978;
    position: relative;
    z-index: 2;
}

.live-clock {
    font-size: 24px;
    font-weight: 600;
    color: #2c3e50;
    background: rgba(255, 255, 255, 0.9);
    padding: 20px 35px;
    border-radius: 20px;
    margin: 20px 0;
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    width: 250px;
}

@media (max-width: 992px) {
    .info-card {
        flex: 1 1 calc(50% - 16px);
    }
}

@media (max-width: 600px) {
    .info-card {
        flex: 1 1 100%;
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

    .live-clock {
        font-size: 20px;
        padding: 15px 25px;
        width: 220px;
    }
}



 .quick-actions-section {
        margin-bottom: 32px;
    }

    .section-title {
        color: #064e17;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .action-card {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid #f3f4f6;
    }

    .action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(6, 78, 23, 0.1);
        border-color: #064e17;
    }

    .action-icon {
        width: 48px;
        height: 48px;
        background-color: #f0fdf4;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: #064e17;
        font-size: 20px;
    }

    .action-title {
        color: #064e17;
        font-size: 14px;
        font-weight: 600;
        margin: 0;
    }

    @media (max-width: 768px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }


</style>

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

    <h1 class="dashboard-title">{{ $greeting }}, {{ $faculty->name }} </h1>

 {{-- Optional Add time --}}
    {{-- <div class="live-clock" id="live-clock"></div> --}}


    <div class="info-cards">
        <div class="info-card">
            <i class="fas fa-users card-icon"></i>
            <div class="card-bg-pattern"></div>
            <h3 class="card-title">Total Trainees</h3>
            <div class="card-number">{{$totalStudents}}</div>
            <a href="{{ route('faculty.students.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
        </div>

        <div class="info-card">
            <i class="fas fa-book card-icon"></i>
            <div class="card-bg-pattern"></div>
            <h3 class="card-title">Journal Submissions</h3>
            <div class="card-number">{{ $journalCount }}</div>
            <a href="{{ route('faculty.journals.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
        </div>

         <div class="info-card">
            <i class="fas fa-building card-icon"></i>
            <div class="card-bg-pattern"></div>
            <h3 class="card-title">Total Companies</h3>
            <div class="card-number">{{ $totalCompanies }}</div>
            <a href="{{ route('faculty.manage-companies.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
        </div>

        <div class="info-card">
            <i class="fas fa-comment-dots card-icon"></i>
            <div class="card-bg-pattern"></div>
            <h3 class="card-title">Company Feedbacks</h3>
            <div class="card-number">{{ $feedbackTotal}}</div>
            <a href="{{ route('faculty.feedbacks.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
        </div>

        <!-- Attendance Completion Card -->
        <div class="info-card">
            <i class="fas fa-chart-line card-icon"></i>
            <div class="card-bg-pattern"></div>

            <h3 class="card-title">Attendance Completion</h3>

            <!-- Progress Bar -->
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $completionPercent }}%;">
                    {{ $completionPercent }}%
                </div>
            </div>

            <!-- Breakdown -->
            <p class="attendance-breakdown">
                <strong>{{ $completedCount }}</strong> completed,
                <strong>{{ $partialCount }}</strong> partial,
                <strong>{{ $notStartedCount }}</strong> not started
            </p>
        </div>
    </div>

    <!-- Quick Actions Section -->
<div class="quick-actions-section" style="margin-top: 30px;">
    <h3 class="section-title">Quick Actions</h3>
    <div class="quick-actions">
        <a href="{{ route('faculty.manage-students.create') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <p class="action-title">Add Trainee</p>
        </a>

        <a href="{{ route('faculty.manage-companies.create') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-building"></i>
            </div>
            <p class="action-title">Add Company</p>
        </a>

        <a href="{{ route('faculty.students.exportPdf') }}" class="action-card">
            <div class="action-icon">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <p class="action-title">Download latest report</p>
        </a>
    </div>
</div>


</div>

<script>
    function updateClock() {
        let now = new Date();

        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
        let ampm = hours >= 12 ? 'PM' : 'AM';

        // Convert 24h to 12h format
        hours = hours % 12;
        hours = hours ? hours : 12;

        // Add leading zeros
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        let timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

        document.getElementById('live-clock').innerText = timeString;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>

@endsection
