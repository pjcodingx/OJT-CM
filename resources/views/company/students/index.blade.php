@extends('layouts.company')
@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .title {
        font-size: 28px;
        color: #043306;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .filters {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .filters input {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        width: 250px;
        font-size: 14px;
    }

    .filters input:focus {
        outline: none;
        border-color: #14532d;
        box-shadow: 0 0 0 2px rgba(20, 83, 45, 0.1);
    }

    .filters select {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background: white;
        font-size: 14px;
        cursor: pointer;
    }

    .filters select:focus {
        outline: none;
        border-color: #14532d;
    }

    .table-wrapper {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .student-table {
        width: 100%;
        border-collapse: collapse;
    }

    .student-table th, .student-table td {
        padding: 16px;
        text-align: center;
        border: 1px solid #e5e7eb;
    }

    .student-table th {
        background-color: #14532d;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .student-table tr {
        color: rgb(10, 0, 0);

        font-size: 16px;
    }

    .student-table tbody tr:hover {
        background-color: #f9fafb;
    }

    .student-table tbody tr:nth-child(even) {
        background-color: #fafafa;
    }

    .student-table tbody tr:nth-child(even):hover {
        background-color: #f3f4f6;
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
            padding: 15px;
        }

        .filters div {
            flex-direction: column !important;
            align-items: stretch !important;
        }

        .filters input {
            width: 100%;
            margin-bottom: 10px;
        }

        .student-table th,
        .student-table td {
            padding: 10px 8px;
            font-size: 13px;
        }
    }
</style>

<div class="container">
    <div class="title">Assigned Students</div>

    <div class="filters" style="margin-bottom: 20px;">
        <form method="GET" action="{{ route('company.students.index') }}">
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name"
                >

                {{-- I think this is not needed --}}
                {{-- <select name="sort" onchange="this.form.submit()">
                    <option value="">Sort by Hours</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Least to Greatest</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Greatest to Least</option>
                </select> --}}

            </div>
        </form>
    </div>

    <div class="table-wrapper">
        <table class="student-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>OJT Adviser</th>
                    <th>Total Hours Accumulated</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->faculty->name ?? '--' }}</td>
                        <td>{{ number_format($student->accumulated_hours ?? 0, 1) }} / {{ $student->required_hours }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No assigned students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $students->links('vendor.pagination.prev-next-only') }}
    </div>
</div>
@endsection
