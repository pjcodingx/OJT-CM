@extends('layouts.admin')

@section('content')
<style>

    .page-container {
        padding: 20px;
        background-color: #f4f6f4;
    }


    .page-title {
        font-size: 24px;
        font-weight: bold;
        color: #1b4332;
        margin-bottom: 20px;
    }


    .filter-form {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        background-color: #fff;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .filter-form label {
        font-weight: bold;
        color: #1b4332;
        display: block;
        margin-bottom: 5px;
    }

    .filter-form select,
    .filter-form input[type="date"] {
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 6px;
        width: 100%;
    }

    .filter-form button {
        background-color: #1b4332;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        margin-top: 22px;
    }

    .filter-form button:hover {
        background-color: #14532d;
    }


    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
    }

    thead {
        background-color: #1b4332;
        color: rgb(10, 0, 0);
    }

    th, td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        color: #ffffff;
    }
    td{
        color: #000000;
        font-size: 17px;
    }




    .empty-row {
        text-align: center;
        color: #666;
        padding: 15px;
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


tbody tr:hover{
    background-color: #c3f1d5;

}
</style>

<div class="page-container">
    <h2 class="page-title">Student Journals</h2>


    <form method="GET" action="{{ route('admin.index') }}" class="filter-form">
        <div style="flex: 1; min-width: 200px;">
            <label for="faculty_id">Filter by Faculty</label>
            <select name="faculty_id" id="faculty_id" onchange="this.form.submit()">
                <option value="">All Faculties</option>
                @foreach(\App\Models\Faculty::all() as $faculty)
                    <option value="{{ $faculty->id }}" {{ request('faculty_id') == $faculty->id ? 'selected' : '' }}>
                        {{ $faculty->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="flex: 1; min-width: 150px;">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">
        </div>

        <div style="flex: 1; min-width: 150px;">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">
        </div>

        <div style="flex: 0;">
            <button type="submit">Filter</button>
        </div>
    </form>


    <table>
        <thead>
            <tr>
                <th>Date Submitted</th>
                <th>Student Name</th>
                <th>Faculty</th>
                <th>Company Assigned</th>


                <th>Journal Content</th>
            </tr>
        </thead>
        <tbody>
            @forelse($journals as $journal)
                <tr>
                    <td>{{ $journal->created_at->format('Y-m-d') }}</td>
                    <td>{{ $journal->student->name }}</td>
                    <td>{{ $journal->student->faculty->name ?? 'N/A' }}</td>
                    <td>{{ $journal->student->company->name ?? 'N/A' }}</td>

                    <td>{{ Str::limit($journal->content, 50) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-row">No journals found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

  bodydiv class="pagination">
        {{ $journals->withQueryString()->links('vendor.pagination.prev-next-only') }}
    </div>
</div>
@endsection
