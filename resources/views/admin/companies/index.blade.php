@extends('layouts.admin')

@section('content')

<style>
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

    .add-btn {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
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
        color: black;
    }

    .student-table th {
        background-color: #064e17;
        color: white;
    }

    .actions-inline {
        display: flex;
        justify-content: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .edit-btn {
        background-color: #17a2b8;
        color: white;
    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
    }

    .search-form {
        margin-bottom: 20px;
    }

    .search-form-group {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-input {
        padding: 12px 14px;
        width: 250px;
        border: 1px solid #2e7d32;
        border-radius: 8px;
        background-color: #fafffb;
        color: #043607;
        font-size: 15px;
        outline: none;
    }

    .search-button {
        padding: 10px 20px;
        background-color: #2e7d32;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        cursor: pointer;
    }

    .search-button:hover {
        background-color: #1b5e20;
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
        border-radius: 6px;
        font-size: 14px;
        font-weight: bold;
        text-decoration: none;
    }

    .page-link:hover {
        background-color: #1e7c43;
    }

    .page-item.disabled .page-link {
        background-color: #5c7f6e;
        color: #ccc;
    }

    .number{
        color:#043607;
    }
    .number:hover{
        color:red;
    }
    tbody tr:hover {
        background-color: #d1e7dd;
    }
    h1{
        color: rgb(5, 51, 1);
        margin-bottom: 19px;
    }

    .btn-success {
    background-color: #02643d;
    color: #fff;
    border: none;
    padding: 8px 10px;
    border-radius: 4px;
    font-size: 12px;

    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    transition: background-color 0.2s ease;
    margin-top: 15px;
}
.btn-success:hover {
    background-color: #03ce87;
}

.btn-red {
    background-color: #b02a37;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;

    text-decoration: none;
    display: inline-block;
    transition: background-color 0.2s ease;
}

.btn-red:hover {
    background-color: #d63343;
}

</style>

<h1>Companies</h1>



    <form method="GET" action="{{ route('admin.companies.index') }}" class="search-form">
        <div class="search-form-group">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, address, or location" class="search-input">

             <select name="status" onchange="this.form.submit()" style="padding: 14px;" class="search-input">
                    <option value="">Filter by Status</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Disabled</option>
            </select>

            <button type="submit" class="search-button">Search</button>





        </div>
    </form>

<div class="table-container">
    <table class="student-table">
        <thead>
            <tr>

                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Status</th>

                <th>Trainees Assigned</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @forelse($companies as $company)
            <tr>
                {{-- <td>{{ $loop->iteration }}</td> --}}
                <td>{{ $company->name }}</td>
                <td>{{ $company->email }}</td>
                <td>{{ $company->address ?? 'N/A' }}</td>

                <td>
                    @if($company->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-success">Disabled</span>
                    @endif
                </td>


                <td>
                    <a href="{{ route('admin.companies.students', $company->id) }}" class="number">
                    {{ $company->students_count }}
                    </a>
                </td>

                <td>
                    <form action="{{ route('companies.toggleStatus', $company->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        @if($company->status)
                           <button type="submit" class="btn-red">Disable</button>
                        @else
                            <button type="submit" class="btn-success">Activate</button>
                        @endif

                    </form>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="7">No companies found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    {{ $companies->withQueryString()->links('vendor.pagination.prev-next-only') }}
</div>

@endsection
