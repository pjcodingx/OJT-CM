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
    <h2>Companies partnered with {{ $faculty->name }}</h2>
    <a href="{{ route('admin.faculties.index') }}" class="back-btn" >&#8592; Back</a>
</div>

@if($faculty->companies->count())
<table>
    <thead>
        <tr>

            <th>Company Name</th>
            <th>Email</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach($faculty->companies as $company)
        <tr>

            <td>{{ $company->name }}</td>
            <td>{{ $company->email }}</td>
            <td>{{ $company->address }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination-wrapper">
    {{ $companies->links('vendor.pagination.prev-next-only') }}
</div>

@else
<p class="no-data">No partnered companies found for this adviser.</p>
@endif

@endsection
