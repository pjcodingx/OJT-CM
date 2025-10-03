@extends('layouts.admin')

@section('content')
<style>
* {
    box-sizing: border-box;
}

.container {
    max-width: 1400px;
    margin: 20px auto;
    padding: 30px;
    background-color: #ffffff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

h2 {
    color: #14532d;
    margin-bottom: 30px;
    font-size: 28px;
    font-weight: 600;
    border-bottom: 3px solid #14532d;
    padding-bottom: 12px;
}

.filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
    align-items: flex-end;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    background-color: #f9fafb;
}

.filter-form input[type="date"],
.filter-form select,
.filter-form input[type="search"] {
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    min-width: 180px;
    height: 42px;
    background-color: #ffffff;
    color: #1f2937;
    font-size: 14px;
    transition: all 0.2s ease;
}

.filter-form input[type="date"]:focus,
.filter-form select:focus,
.filter-form input[type="search"]:focus {
    outline: none;
    border-color: #14532d;
    box-shadow: 0 0 0 3px rgba(20, 83, 45, 0.1);
}

.filter-form input[type="search"]::placeholder {
    color: #9ca3af;
}

.filter-form label {
    font-size: 13px;
    color: #374151;
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
}

.filter-form button {
    padding: 10px 24px;
    background-color: #14532d;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.filter-form button:hover {
    background-color: #166534;
    transform: translateY(-1px);
}

.export-buttons {
    margin-bottom: 20px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 10px;
    font-size: 14px;
    background-color: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}

th, td {
    padding: 14px 16px;
    text-align: left;
    white-space: normal;
}

td {
    color: #1f2937;
    border-bottom: 1px solid #e5e7eb;
}

th {
    background-color: #14532d;
    color: #ffffff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 12px;
}

tbody tr {
    transition: background-color 0.15s ease;
}

tbody tr:hover {
    background-color: #d1fae5;
}

tbody tr:nth-child(even) {
    background-color: #f9fafb;
}

tbody tr:last-child td {
    border-bottom: none;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 8px;
}

.no-data {
    color: #dc2626;
    font-style: italic;
    padding: 40px;
    text-align: center;
    font-size: 16px;
    background-color: #fef2f2;
    border-radius: 8px;
    border: 1px solid #fecaca;
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
    gap: 10px;
}

.pagination .page-item {
    display: inline-block;
}

.page-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: #14532d;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
}

.page-link:hover {
    background-color: #166534;
    transform: translateY(-1px);
}

.page-item.disabled .page-link {
    background-color: #d1d5db;
    color: #9ca3af;
    cursor: not-allowed;
}

.page-item.disabled .page-link:hover {
    transform: none;
}

.page-indicator .page-link.static {
    background-color: transparent;
    color: #6b7280;
    font-weight: 600;
    cursor: default;
    padding: 10px 0;
    border: none;
}

.btn-green {
    background-color: #14532d;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
}

.btn-green:hover {
    background-color: #166534;
    transform: translateY(-1px);
}

.btn-red {
    background-color: #dc2626;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
}

.btn-red:hover {
    background-color: #b91c1c;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .container {
        max-width: 100%;
        padding: 15px;
        margin: 10px auto;
    }

    h2 {
        font-size: 22px;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    table {
        min-width: 900px;
        font-size: 12px;
    }

    th, td {
        padding: 10px 12px;
        white-space: nowrap;
    }

    .filter-form {
        flex-direction: column;
        gap: 12px;
        padding: 15px;
    }

    .filter-form input,
    .filter-form select,
    .filter-form button {
        width: 100%;
    }

    .export-buttons {
        flex-direction: column;
    }

    .btn-green,
    .btn-red {
        width: 100%;
        text-align: center;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .container {
        max-width: 95%;
        padding: 20px;
    }
}
</style>

<div class="container">
    <h2>All Students Attendance Logs</h2>

    <form method="GET" class="filter-form" action="{{ route('admin.attendance') }}">
        <input type="search" name="search" placeholder="Search student name" value="{{ old('search', $search) }}">

        <select name="course_id">
            <option value="">-- Filter by Course --</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" @if($course->id == $course_id) selected @endif>{{ $course->name }}</option>
            @endforeach
        </select>

        <select name="faculty_id">
            <option value="">-- Filter by Faculty Adviser --</option>
            @foreach ($faculties as $faculty)
                <option value="{{ $faculty->id }}" @if($faculty->id == $faculty_id) selected @endif>{{ $faculty->name }}</option>
            @endforeach
        </select>

        <div>
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" value="{{ old('start_date', $start_date) }}">
        </div>
        <div>
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" value="{{ old('end_date', $end_date) }}">
        </div>

        <button type="submit">Apply Filters</button>
    </form>

    <div class="export-buttons">
        <a href="{{ route('admin.attendance.export.excel', request()->query()) }}" class="btn-green">
            Export to Excel
        </a>
        <a href="{{ route('admin.attendance.export.pdf', request()->query()) }}" class="btn-red">
            Export to PDF
        </a>
    </div>

    @if ($attendances->count())
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Faculty Adviser</th>
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
                    <td>{{ $attendance->student->course->name ?? '-' }}</td>
                    <td>{{ $attendance->student->faculty->name ?? '-' }}</td>
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
    </div>

    <div class="pagination-wrapper">
        {{ $attendances->withQueryString()->links('vendor.pagination.prev-next-only') }}
    </div>
    @else
        <p class="no-data">No attendance logs found.</p>
    @endif
</div>
@endsection
