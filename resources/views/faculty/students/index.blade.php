@extends('layouts.faculty')

@section('content')
<style>
    tr {
        color: black;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h2 {
        font-size: 24px;
        font-weight: bold;
        color: black;
    }

    .filters {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filters input,
    .filters select {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    .table-container {
        margin-top: 20px;
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
        color: #fff;
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

    .search-button {
        padding: 10px 20px;
        background-color: #2e7d32;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .search-button:hover {
        background-color: #1b5e20;
    }

    tbody tr:hover {
        background-color: #d1e7dd;
    }

    tbody{
        background: rgb(255, 255, 255);
    }
</style>

<div class="page-header">
    <h2>My Students</h2>
</div>

<div class="filters">
    <form method="GET" action="{{ route('faculty.students.index') }}">
        <div style="display: flex; gap: 10px; align-items: center;">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by name"
                style="padding: 14px; width: 250px;"
            >

            {{-- <select name="sort" onchange="this.form.submit()" style="padding: 14px;">
                <option value="">Sort by Hours</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Least to Greatest</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Greatest to Least</option>
            </select> --}}

            {{-- <button type="submit" class="search-button">Search</button> --}}
        </div>
    </form>
</div>

<div class="table-container">
    <table class="student-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Company</th>
                <th>Company Address</th>
                <th> OJT Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->course->name ?? 'Not Assigned' }}</td>
                <td>{{ $student->company->name ?? '--' }}</td>
                <td>{{ $student->company->address ?? '--' }}</td>
                <td>{{ $student->accumulated_hours }} / {{ $student->required_hours }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    {{ $students->withQueryString()->links('vendor.pagination.prev-next-only') }}
</div>
@endsection
