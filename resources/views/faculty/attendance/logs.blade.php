@extends('layouts.faculty')

@section('content')
<style>
.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.header-section {
    background-color: #14532d;
    padding: 24px 32px;
    border-radius: 8px 8px 0 0;
}

.header-section h2 {
    color: #fff;
    margin: 0;
    font-size: 24px;
    font-weight: 600;
}

.content-section {
    background-color: #fff;
    padding: 32px;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.filter-form {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
    align-items: end;
}

.filter-group {
    flex: 1;
}

.filter-group label {
    display: block;
    margin-bottom: 6px;
    color: #374151;
    font-weight: 500;
    font-size: 14px;
}

.filter-form input[type="date"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
}

.filter-form input[type="date"]:focus {
    outline: none;
    border-color: #14532d;
}

.filter-form button {
    padding: 10px 24px;
    background-color: #14532d;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    font-size: 14px;
}

.filter-form button:hover {
    background-color: #166534;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

thead {
    background-color: #14532d;
}

th {
    padding: 12px;
    color: white;
    font-weight: 600;
    text-align: left;
    font-size: 13px;
}

td {
    padding: 12px;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
}

tbody tr:hover {
    background-color: #f9fafb;
}

.pagination-wrapper {
    text-align: center;
    margin-top: 24px;
}

.pagination {
    list-style: none;
    padding: 0;
    margin: 0;
    display: inline-flex;
    gap: 10px;
}

.page-link {
    display: inline-block;
    padding: 8px 16px;
    background-color: #14532d;
    color: #fff;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
}

.page-link:hover {
    background-color: #166534;
}

.page-item.disabled .page-link {
    background-color: #d1d5db;
    cursor: not-allowed;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #dc2626;
    font-style: italic;
}

@media (max-width: 768px) {
    .container {
        margin: 20px;
    }

    .filter-form {
        flex-direction: column;
    }

    .filter-form button {
        width: 100%;
    }
}
</style>

<div class="container">
    <div class="header-section">
        <h2>Attendance Logs</h2>
    </div>

    <div class="content-section">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="filter-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}">
            </div>
            <button type="submit">Filter</button>
        </form>

        @if ($attendances->count())
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Accumulated Hours</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->student->name }}</td>
                    <td>{{ $attendance->student->email }}</td>
                    <td>{{ $attendance->student->company->name ?? '-' }}</td>
                    <td>{{ $attendance->student->company->address ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('F d, Y') }}</td>
                    <td>{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}</td>
                    <td>{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}</td>
                    <td>{{ $attendance->student->accumulated_hours }} hrs</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $attendances->withQueryString()->links('vendor.pagination.prev-next-only') }}
        </div>
        @else
            <p class="no-data">No attendance logs found!</p>
        @endif
    </div>
</div>
@endsection
