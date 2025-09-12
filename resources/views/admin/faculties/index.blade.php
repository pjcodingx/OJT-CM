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

    .view-btn {
        background-color: #007bff;
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


.search-input,
.search-select {
    padding: 12px 14px;
    width: 250px;
    border: 1px solid #2e7d32;
    border-radius: 8px;
    background-color: #fafffb;
    color: #043607;
    font-size: 15px;
    outline: none;
    transition: border 0.2s ease, background-color 0.2s ease;
}

.search-select {
    width: auto;
}

.search-input:focus,
.search-select:focus {
    border: 2px solid #1b5e20;
    background-color: #e8f5e9;
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

.number{
    color: #043607;
}
.number:hover{
    color: red;
}

tbody tr:hover {
        background-color: #d1e7dd;
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



<div class="page-header">
    <h2>Manage Advisers</h2>
    <a href="{{ route('admin.faculties.create') }}" class="add-btn">+ Add Adviser</a>
</div>

        <form method="GET" action="{{ route('admin.faculties.index') }}" class="search-form">
            <div class="search-form-group">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name or email"
                    class="search-input"
                >


                <select name="course_id" onchange="this.form.submit()" class="search-select">
                    <option value=""> Filter by Department </option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>

                 <select name="status" onchange="this.form.submit()" style="padding: 14px;" class="search-select">
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
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Department</th>
                <th>Assigned Students</th>
                <th>Partnered Companies </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faculties as $faculty)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $faculty->name }}</td>
                <td>{{ $faculty->email }}</td>
                <td>
                    @if($faculty->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>{{ $faculty->course->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.faculties.students', $faculty) }}" class="number">
                        {{ $faculty->students_count }}
                    </a>
                </td>

                <td>
                    <a href="{{ route('admin.faculties.companies', $faculty) }}" class="number">
                        {{ $faculty->companies->count() }}
                    </a>
                </td>

                <td>
                    <div class="actions-inline">
                        <a href="{{ route('admin.faculties.edit', $faculty->id) }}">
                            <button class="action-btn edit-btn">Edit</button>
                        </a>

                        <form action="{{ route('faculties.toggleStatus', $faculty->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            @if($faculty->status)
                                <button type="submit" class="btn-red">Disable</button>
                            @else
                                <button type="submit" class="btn-success">Activate</button>
                            @endif
                        </form>


                    </div>
                </td>




            </tr>
            @empty
            <tr>
                <td colspan="6">No advisers found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    {{ $faculties->withQueryString()->links('vendor.pagination.prev-next-only') }}
</div>



@endsection
