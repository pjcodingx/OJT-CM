@extends('layouts.company')

@section('content')

<style>
.dashboard-title {
    color: #043306;
    margin-top: -30px;
    margin-bottom: 50px;
}

.info-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 16px;
}

.info-card {
    background-color: #1f1f1f;
    padding: 20px;
    border-radius: 10px;
    color: white;
    min-height: 160px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease-in-out;
}

.info-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
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

.blue-card {
    background-color: #007bff;
}

@media (max-width: 992px) {
    .info-card {
        flex: 1 1 calc(50% - 16px);
    }
}

@media (max-width: 600px) {
    .info-card {
        flex: 1 1 100%;
    }

    .dashboard-title {
        font-size: 22px;
    }

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
</style>

<div class="dashboard-content">
    <h1 class="dashboard-title">Company Overview</h1>

    <div class="info-cards">

        <div class="info-card green-card">
            <h3 class="card-title">Total Trainees</h3>
            <div class="card-number">{{ $studentsCount }}</div>
            <a href="{{ route('company.students.index') }}" class="card-link">More info <i class="fas fa-chevron-right"></i></a>
        </div>



        <div class="info-card red-card">
            <h3 class="card-title">Feedbacks</h3>
            <div class="card-number">{{ $totalRatings }}</div>
            <a href="{{ route('company.students.rating.index') }}" class="card-link">View All <i class="fas fa-chevron-right"></i></a>
        </div>


        <div class="info-card blue-card">
            <h3 class="card-title">Time-In Today</h3>
            <div class="card-number">{{ $timeInCountToday }}</div>
            <a href="{{ route('company.attendance.logs') }}" class="card-link">Attendance Logs <i class="fas fa-chevron-right"></i></a>
        </div>

         <div class="info-card yellow-card">
            <h3 class="card-title">Pending Appeals</h3>
            <div class="card-number">{{ $pendingAppeals }}</div>
            <a href="{{ route('company.attendance-appeals.index') }}" class="card-link">Show<i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</div>

@endsection
