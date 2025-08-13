@extends('layouts.admin') {{-- Adjust this to your admin layout --}}

@section('content')
<style>
.container {
    max-width: 1400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    font-family: Arial, sans-serif;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    overflow-x: auto;
}
h2 {
    color: #14532d;
    margin-bottom: 20px;
}
.filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
    align-items: flex-end;
}
.filter-form input[type="date"],
.filter-form select,
.filter-form input[type="search"] {
    padding: 5px;
    border: 1px solid #fcfcfc;
    border-radius: 6px;
    min-width: 150px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);



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
    text-align: left;
    white-space: normal;
}



td {
    color: black;
}
th {
    background-color: #14532d;
    color: white;
}
.pagination-wrapper {
    margin-top: 20px;
    text-align: center;
}
.no-data {
    color: red;
    font-style: italic;
    padding: 10px;
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

@media (max-width: 768px) {
  .container {
    max-width: 100% !important;
    padding: 10px;
    margin: 10px auto;
    overflow-x: visible;
  }

  .table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  table {
    min-width: 900px;
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
  }

  th, td {
    padding: 6px 8px;
    white-space: nowrap;
  }

  .filter-form {
    flex-direction: column;
    gap: 10px;
  }

  .filter-form input, .filter-form select, .filter-form button {
    width: 100%;
  }
}


tbody tr:hover {
        background-color: #d1e7dd;
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
            <label for="start_date" style="font-size: 18px;">Start Date</label><br>
            <input type="date" name="start_date" value="{{ old('start_date', $start_date) }}">
        </div>
        <div>
            <label for="end_date" style="font-size: 18px;">End Date</label><br>
            <input type="date" name="end_date" value="{{ old('end_date', $end_date) }}">
        </div>

        <button type="submit">Filter</button>
    </form>

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
        <p class="no-data">No attendance logs found with the applied filters.</p>
    @endif
</div>
@endsection
