@extends('layouts.faculty')

@section('content')
<style>
    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .page-header h2 {
        font-size: 24px;
        font-weight: bold;
        color: #064e17;
    }


    .filters {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .filters input {
        padding: 8px 12px;
        border: 1px solid #064e17;
        border-radius: 6px;
        font-size: 14px;
    }
    .search-button {
        padding: 10px 20px;
        background-color: #064e17;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .search-button:hover {
        background-color: #178041;
    }




    .table-container {
        overflow-x: auto;
    }
    .student-table {
        width: 100%;
        border-collapse: collapse;
    }
    .student-table th,
    .student-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
        font-size: 14px;
        vertical-align: middle;
    }
    .student-table th {
        background-color: #064e17;
        color: white;
    }
    .student-table tbody tr:hover {
        background-color: #d1e7dd;
    }

    /* Pagination */
    .pagination-wrapper {
        text-align: center;
        margin-top: 20px;
    }

    tbody tr{
        color: black;
    }
</style>

<div class="page-header">
    <h2>My Students Summary Report</h2>

    <p style="color: rgba(21, 51, 2, 0.6); margin: 0 ; font-size: 16px;">
        {{ \Carbon\Carbon::now()->format('F d, Y') }}
    </p>
</div>


<div class="filters">
    <form method="GET" action="{{ route('faculty.reports.index') }}">
        <input type="text" name="search" placeholder="Search by name or address" value="{{ request('search') }}">
        <button type="submit" class="search-button">Search</button>

        <a href="{{ route('faculty.students.exportExcel', request()->query()) }}" class="search-button" style="background-color:#0b4222; text-decoration: none;">Export Excel</a>
        <a href="{{ route('faculty.students.exportPdf', request()->query()) }}" class="search-button" style="background-color:#b91206; text-decoration: none;">Export PDF</a>


    </form>
</div>



<div class="table-container">
    <table class="student-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Address</th>
                <th>Total Journals</th>
                <th>Rating</th>
                <th>Total Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->company->name ?? '--' }}</td>
                <td>{{ $student->company->address ?? '--' }}</td>
                <td>{{ $student->total_journals }}</td>
                <td>{{ number_format($student->average_rating ?? 0, 0) . '/' . '5'}}</td>
                <td>{{ round($student->total_hours ?? 0, 1,) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    {{ $students->withQueryString()->links('vendor.pagination.prev-next-only') }}
</div>
@endsection
