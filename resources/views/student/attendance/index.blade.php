@extends('layouts.student')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    h2.table-title {
        color: #107936;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-align: center;
    }

    .filter-form {
        max-width: 400px;
        margin: 0 auto 2rem auto;
        text-align: center;
    }

    .date-input {
        padding: 0.5rem 1rem;
        border: 2px solid #107936;
        border-radius: 12px;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        width: 100%;
        max-width: 250px;
        cursor: pointer;
    }

    .date-input:focus {
        border-color: #0f6a2f;
        box-shadow: 0 0 6px rgba(15, 106, 47, 0.5);
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin: 0 auto;
    }

    thead {
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
    }

    thead th {
        padding: 1rem 1.25rem;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        text-align: center;
        user-select: none;
    }

    tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.3s ease;
    }

    tbody tr:hover {
        background: #ecfdf5;
    }

    tbody td {
        padding: 1rem 1.25rem;
        color: #475569;
        font-size: 1rem;
        text-align: center;
    }

    tbody td[colspan="3"] {
        text-align: center;
        color: #9ca3af;
        font-style: italic;
        padding: 2rem;
    }

    .pagination-wrapper {
        max-width: 400px;
        margin: 2rem auto;
        display: flex;
        justify-content: center;
    }
</style>

<h2 class="table-title">Attendance Logs</h2>

<form method="GET" action="{{ route('student.attendance.index') }}" class="filter-form" novalidate>
    <input
        type="date"
        name="date"
        class="date-input"
        value="{{ request('date') }}"
        onchange="this.form.submit()"
        aria-label="Filter attendance logs by date"
    >
</form>

<table aria-label="Attendance Logs">
    <thead>
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Time In</th>
            <th scope="col">Time Out</th>
        </tr>
    </thead>
    <tbody>
        @forelse($attendances as $attendance)
            <tr>
                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('F d, Y') }}</td>
                <td>{{ $attendance->time_in ?? '—' }}</td>
                <td>{{ $attendance->time_out ?? '—' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No attendance records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination-wrapper">
    {{ $attendances->withQueryString()->links('vendor.pagination.prev-next-only') }}
</div>
@endsection
