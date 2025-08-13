@extends('layouts.company')

@section('content')
<style>

    h2 {
        color: #107936;
        font-weight: 700;

        margin-bottom: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }


    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    thead tr {
        background-color: #2c5f2d;
        color: #fff;
        font-weight: 600;
        text-align: left;
        font-size: 18px;
        border-radius: 8px;
    }

    thead th {
        padding: 12px 15px;
        user-select: none;
    }

    tbody tr {
        background-color: #f9fafb;
        box-shadow: 0 2px 5px rgb(0 0 0 / 0.05);
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    tbody tr:hover {
        background-color: #c7f8d5;
    }

    tbody td {
        padding: 12px 15px;
        font-size: 14px;
        color: #374151;
        vertical-align: middle;
        border-radius: 8px;
    }


    .stars {
        color: #fbbf24;
        font-size: 16px;
        letter-spacing: 2px;
    }


    a.action-link {
        color: #107936;
        font-weight: 600;
        text-decoration: none;
        padding: 6px 14px;
        border: 2px solid #107936;
        border-radius: 6px;
        transition: background-color 0.3s ease, color 0.3s ease;
        display: inline-block;
        font-size: 14px;
    }

    a.action-link:hover {
        background-color: #107936;
        color: white;
    }


    .success-message {
        background-color: #d1fae5;
        color: #065f46;
        padding: 10px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 600;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
</style>

<h2>Rate Students</h2>

@if(session('success'))
    <div class="success-message">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Total OJT Hours</th>
            <th>Stars Given</th>
            <th>Feedback</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        @php
            $rating = $student->ratings->first();
        @endphp
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->total_ojt_hours ?? 0 }}</td>
            <td class="stars">
                @if($rating)
                    {{ str_repeat('⭐', $rating->rating) }}
                @else
                    -
                @endif
            </td>
            <td>{{ $rating ? \Illuminate\Support\Str::limit($rating->feedback, 50) : '-' }}</td>
            <td>
                <a href="{{ route('company.students.rating.edit', $student->id) }}" class="action-link">Give Feedback</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination-wrapper">
        {{ $students->withQueryString()->links('vendor.pagination.prev-next-only') }}
    </div>
@endsection
