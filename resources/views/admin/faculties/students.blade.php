@extends('layouts.admin')

@section('content')

<style>
    .page-header {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .page-header h2 {
        font-size: 28px;
        font-weight: 700;
        color: #14532d;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px 12px;
        text-align: left;
        font-size: 15px;
        color: #222;
    }
    th {
        background-color: #14532d;
        color: white;
    }
    tbody tr:nth-child(even) {
        background-color: #f3f6f4;
    }
    tbody tr:hover {
        background-color: #d1e7dd;
    }

    .no-data {
        padding: 20px;
        text-align: center;
        font-style: italic;
        color: red;
    }

    .pagination-wrapper {
        margin-top: 20px;
        text-align: center;
    }

     .back-btn {
        display: inline-block;
        margin-bottom: 15px;
        background-color: #14532d;
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    .back-btn:hover {
        background-color: #1e7c43;
    }

</style>

<div class="page-header">
    <h2>Students assigned to {{ $faculty->name }}</h2>
     <a href="{{ route('admin.faculties.index') }}" class="back-btn" >&#8592; Back</a>
</div>

@if($students->count())
<table>
    <thead>
        <tr>

            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Company</th>
            <th>Company Address</th>
            <th>Accumulated Hours</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>

            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->course->name ?? 'N/A' }}</td>
            <td>{{ $student->company->name ?? '-' }}</td>
            <td>{{ $student->company->address ?? '-' }}</td>
            <td>{{ number_format($student->accumulated_hours, 2) }} hrs</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination-wrapper">
    {{ $students->links('vendor.pagination.prev-next-only') }}
</div>

@else
<p class="no-data">No students assigned to this adviser.</p>
@endif

@endsection
