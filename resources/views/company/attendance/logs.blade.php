@extends('layouts.company')

@section('content')
<style>
    .container {
        max-width: 1100px;
        margin: 15px auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        font-family: 'Segoe UI', sans-serif;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #14532d;
        text-align: center;
    }

    .filter-form {
        display: flex;
        gap: 20px;
        align-items: end;
        margin-bottom: 20px;
        color: black;
    }

    .filter-form input[type="date"] {
        padding: 6px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;

    }

    .filter-form button {
        padding: 8px 16px;
        background-color: #14532d;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .filter-form button:hover {
        background-color: #1c6b3d;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        margin-top: 10px;
    }

    th, td {
        padding: 10px;
        border-bottom: 1px solid #ccc;
        text-align: left;
    }
    td{
        color: black;
    }
    th {
        background-color: #14532d;
        color: white;
    }

    .pagination-wrapper {
    text-align: center;
    margin-top: 30px;
    font-family: Verdana, sans-serif;
}

.pagination {
    list-style: none;
    padding: 0;
    margin: 0;
    display: inline-flex;
    align-items: center;
    gap: 15px;
}

.pagination .page-item {
    display: inline-block;
}


.page-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: #14532d;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
}


.page-link:hover {
    background-color: #1e7c43;
    transform: translateY(-1px);
}


.page-item.disabled .page-link {
    background-color: #5c7f6e;
    color: #ccc;
    cursor: not-allowed;
}


.page-indicator .page-link.static {
    background-color: transparent;
    color: #98afa2;
    font-weight: bold;
    cursor: default;
    padding: 10px 0;
    border: none;
    opacity: 0.5;
}

    .no-data {
        color: red;
        font-style: italic;
        padding: 10px 0;
    }
    tbody tr:hover {
        background-color: #d1e7dd;
    }
</style>

<div class="container">
    <h2>Attendance Logs</h2>

    <form method="GET" class="filter-form">
        <div>
            <label for="start_date">Start Date</label><br>
            <input type="date" name="start_date" value="{{ $startDate }}">
        </div>
        <div>
            <label for="end_date">End Date</label><br>
            <input type="date" name="end_date" value="{{ $endDate }}">
        </div>
        <button type="submit">Filter</button>
    </form>

    @if ($attendances->count())
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Student</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('F d, Y') }}</td>
                        <td>{{ $attendance->student->name }}</td>
                        <td>{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}</td>
                        <td>{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $attendances->withQueryString()->links('vendor.pagination.prev-next-only') }}
        </div>
    @else
        <p class="no-data">No attendance records found for the selected date range.</p>
    @endif
</div>
@endsection
