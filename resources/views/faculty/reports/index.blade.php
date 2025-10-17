@extends('layouts.faculty')

@section('content')
<style>
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 24px;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 16px;
        border-bottom: 2px solid #064e17;
    }

    .page-header h2 {
        font-size: 28px;
        font-weight: 600;
        color: #064e17;
        margin: 0;
    }

    .page-header .date {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }

    /* Filters Section */
    .filters {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }

    .filters form {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filters input[type="text"] {
        flex: 1;
        min-width: 250px;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
    }

    .filters input[type="text"]:focus {
        outline: none;
        border-color: #064e17;
    }

    .search-button {
        padding: 10px 20px;
        background-color: #064e17;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.2s ease;
    }

    .search-button:hover {
        background-color: #0b5a1f;
    }

    .export-excel {
        background-color: #0b4222;
    }

    .export-excel:hover {
        background-color: #0d5129;
    }

    .export-pdf {
        background-color: #b91206;
    }

    .export-pdf:hover {
        background-color: #d01508;
    }

    /* Table Container */
    .table-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .student-table {
        width: 100%;
        border-collapse: collapse;
    }

    .student-table th {
        background-color: #064e17;
        color: white;
        padding: 14px 12px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .student-table td {
        padding: 12px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: #374151;
    }

    .student-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .student-table tbody tr:hover {
        background-color: #f0fdf4;
    }

    .student-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Center align specific columns */
    .student-table td:nth-child(5),
    .student-table td:nth-child(6),
    .student-table td:nth-child(7),
    .student-table td:nth-child(8),
    .student-table td:nth-child(9),
    .student-table th:nth-child(5),
    .student-table th:nth-child(6),
    .student-table th:nth-child(7),
    .student-table th:nth-child(8),
    .student-table th:nth-child(9) {
        text-align: center;
    }

    /* Pagination */
    .pagination-wrapper {
        text-align: center;
        margin-top: 24px;
    }

    .pagination {
        list-style: none;
        padding: 0;
        margin: 0;
        display: inline-flex;
        gap: 10px;
    }

    .page-link {
        display: inline-block;
        padding: 8px 16px;
        background-color: #064e17;
        color: #fff;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
    }

    .page-link:hover {
        background-color: #0b5a1f;
    }

    .page-item.disabled .page-link {
        background-color: #d1d5db;
        cursor: not-allowed;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .filters form {
            flex-direction: column;
            align-items: stretch;
        }

        .filters input[type="text"] {
            width: 100%;
            min-width: auto;
        }

        .search-button {
            width: 100%;
        }

        .student-table {
            font-size: 12px;
        }

        .student-table th,
        .student-table td {
            padding: 8px 6px;
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <h2>Students Summary Report</h2>
        <p class="date">{{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
    </div>

    <div class="filters">
        <form method="GET" action="{{ route('faculty.reports.index') }}">
            <input type="text" name="search" placeholder="Search by name or address" value="{{ request('search') }}">
            <button type="submit" class="search-button">Search</button>
            <a href="{{ route('faculty.students.exportExcel', request()->query()) }}" class="search-button export-excel">Export Excel</a>
            <a href="{{ route('faculty.students.exportPdf', request()->query()) }}" class="search-button export-pdf">Export PDF</a>
        </form>
    </div>

    <div class="table-container">
        <div class="table-wrapper">
            <table class="student-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Address</th>
                        <th>Total Journals</th>
                        <th>Rating</th>
                        <th>Appeals Submitted</th>
                        <th>Absences</th>
                        <th>OT hours</th>
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
                        <td>{{ number_format($student->average_rating ?? 0, 0) . '/5' }}</td>
                        <td>{{ $student->appealsCount() }}</td>
                        <td>{{ $student->calculateAbsences() }}</td>
                        <td>{{ number_format($student->overtimeRequests()->where('status', 'completed')->sum('approved_hours'), 1) }}</td>
                        <td>{{ number_format($student->accumulated_hours, 1) }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrapper">
        {{ $students->withQueryString()->links('vendor.pagination.prev-next-only') }}
    </div>
</div>
@endsection
