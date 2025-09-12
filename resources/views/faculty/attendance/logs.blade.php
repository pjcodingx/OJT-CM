@extends('layouts.faculty')

@section('content')
<style>
.container {
    max-width: 1000px;
    margin: 30px auto;
    padding: 20px;
    background-color: #fff;
    font-family: Arial, sans-serif;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
h2 {
    color: #14532d;
    margin-bottom: 20px;
}
.filter-form {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    align-items: end;
}
.filter-form input[type="date"] {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.filter-form button {
    padding: 6px 16px;
    background-color: #14532d;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.filter-form button:hover {
    background-color: #1e7c43;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    font-size: 14px;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
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
.no-data {
    color: red;
    font-style: italic;
    padding: 10px;
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
        <tbody class="number">
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
        <p class="no-data">No attendance logs found for the selected date range.</p>
    @endif
</div>
@endsection
