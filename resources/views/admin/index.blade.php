@extends('layouts.admin')

@section('content')
<style>
    .page-container {
        padding: 30px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: #1b4332;
        margin-bottom: 30px;
        letter-spacing: -0.5px;
    }

    /* Filter Form Styling */
    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
        padding: 25px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(27, 67, 50, 0.08);
        border: 1px solid rgba(27, 67, 50, 0.1);
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-form label {
        font-weight: 600;
        color: #1b4332;
        font-size: 14px;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-form select,
    .filter-form input[type="date"] {
        padding: 12px 14px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: white;
        color: #1b4332;
    }

    .filter-form select:focus,
    .filter-form input[type="date"]:focus {
        outline: none;
        border-color: #1b4332;
        box-shadow: 0 0 0 3px rgba(27, 67, 50, 0.1);
    }

    .filter-form button {
        background: linear-gradient(135deg, #1b4332 0%, #2d5a3d 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        align-self: flex-end;
        box-shadow: 0 4px 6px rgba(27, 67, 50, 0.2);
    }

    .filter-form button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(27, 67, 50, 0.3);
    }

    .filter-form button:active {
        transform: translateY(0);
    }

    /* Table Styling */
    .table-wrapper {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(27, 67, 50, 0.08);
        border: 1px solid rgba(27, 67, 50, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: linear-gradient(135deg, #1b4332 0%, #2d5a3d 100%);
    }

    th {
        padding: 16px 20px;
        text-align: left;
        color: #ffffff;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-bottom: 3px solid #14532d;
    }

    td {
        padding: 16px 20px;
        color: #374151;
        font-size: 15px;
        border-bottom: 1px solid #f3f4f6;
    }

    tbody tr {
        transition: all 0.2s ease;
    }

    tbody tr:hover {
        background: linear-gradient(90deg, rgba(195, 241, 213, 0.3) 0%, rgba(195, 241, 213, 0.1) 100%);
        transform: scale(1.001);
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .empty-row {
        text-align: center;
        color: #9ca3af;
        padding: 40px 20px;
        font-size: 16px;
        font-weight: 500;
    }

    /* Pagination Styling */
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pagination .page-item {
        display: inline-block;
    }

    .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 44px;
        padding: 10px 18px;
        background: white;
        color: #1b4332;
        border: 2px solid #1b4332;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: #1b4332;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(27, 67, 50, 0.2);
    }

    .page-item.disabled .page-link {
        background: #f3f4f6;
        color: #9ca3af;
        border-color: #e5e7eb;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .page-item.disabled .page-link:hover {
        transform: none;
        box-shadow: none;
        background: #f3f4f6;
        color: #9ca3af;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #1b4332 0%, #2d5a3d 100%);
        color: white;
        border-color: #1b4332;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-container {
            padding: 20px;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-form button {
            align-self: stretch;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            min-width: 800px;
        }
    }
</style>

<div class="page-container">
    <h2 class="page-title">Student Journals</h2>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.index') }}" class="filter-form">
        <div class="filter-group">
            <label for="faculty_id">Faculty</label>
            <select name="faculty_id" id="faculty_id" onchange="this.form.submit()">
                <option value="">All Faculties</option>
                @foreach(\App\Models\Faculty::all() as $faculty)
                    <option value="{{ $faculty->id }}" {{ request('faculty_id') == $faculty->id ? 'selected' : '' }}>
                        {{ $faculty->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">
        </div>

        <div class="filter-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">
        </div>

        <div class="filter-group">
            <label style="opacity: 0;">Filter</label>
            <button type="submit">Apply Filters</button>
        </div>
    </form>

    <!-- Table -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Date Submitted</th>
                    <th>Student Name</th>
                    <th>OJT Adviser</th>
                    <th>Company Assigned</th>
                    <th>Journal Content</th>
                </tr>
            </thead>
            <tbody>
                @forelse($journals as $journal)
                    <tr>
                        <td>{{ $journal->created_at->format('M d, Y') }}</td>
                        <td>{{ $journal->student->name }}</td>
                        <td>{{ $journal->student->faculty->name ?? 'N/A' }}</td>
                        <td>{{ $journal->student->company->name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($journal->content, 50) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-row">No journals found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $journals->withQueryString()->links('vendor.pagination.prev-next-only') }}
    </div>
</div>
@endsection
