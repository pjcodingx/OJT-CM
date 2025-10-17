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

    tbody td[colspan="7"] {
        text-align: center;
        color: #9ca3af;
        font-style: italic;
        padding: 2rem;
    }

    /* Photo Styles */
    .photo-thumbnail {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid #ddd;
        transition: all 0.2s;
    }

    .photo-thumbnail:hover {
        transform: scale(1.15);
        border-color: #107936;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .no-photo-badge {
        display: inline-block;
        padding: 3px 8px;
        background: #fee;
        color: #c33;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 500;
    }

    .photo-cell {
        text-align: center;
    }

    /* Photo Modal */
    .photo-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.95);
        align-items: center;
        justify-content: center;
    }

    .photo-modal.active {
        display: flex;
    }

    .photo-modal-content {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.5);
    }

    .photo-modal-close {
        position: absolute;
        top: 20px;
        right: 40px;
        color: white;
        font-size: 45px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s;
    }

    .photo-modal-close:hover {
        color: #ff6b6b;
    }

    .photo-modal-info {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        background: rgba(0,0,0,0.8);
        padding: 15px 30px;
        border-radius: 8px;
        text-align: center;
        backdrop-filter: blur(10px);
    }

    .photo-modal-info strong {
        font-size: 18px;
        display: block;
        margin-bottom: 5px;
    }

    .pagination-wrapper {
        margin-top: 2.5rem;
    }

    .pagination {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .page-item {
        display: inline-block;
    }

    .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.875rem;
        background-color: #f1f5f9;
        color: #64748b;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        min-width: 2.25rem;
        height: 2.25rem;
    }

    .page-link:hover {
        background-color: #e2e8f0;
        color: #334155;
    }

    .page-item.active .page-link {
        background-color: #10b981;
        color: white;
    }

    .page-item.disabled .page-link {
        background-color: #f1f5f9;
        color: #cbd5e1;
        cursor: not-allowed;
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
            <th scope="col">In Photo</th>
            <th scope="col">Time Out</th>
            <th scope="col">Out Photo</th>
            <th scope="col">OT Photo</th>
            <th scope="col">Hours</th>
        </tr>
    </thead>
    <tbody>
        @forelse($attendances as $attendance)
            <tr>
                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('F d, Y') }}</td>

                @php
                    $hasApprovedAppeal = $attendance->appeals->isNotEmpty();
                @endphp

                <td>
                    {{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : ($hasApprovedAppeal ? 'Present (Appeal)' : '—') }}
                </td>
                <td class="photo-cell">
                    @if($attendance->time_in_photo)
                        <img src="{{ asset('storage/' . $attendance->time_in_photo) }}"
                             class="photo-thumbnail"
                             onclick="openPhotoModal('{{ asset('storage/' . $attendance->time_in_photo) }}', 'Time In', '{{ \Carbon\Carbon::parse($attendance->date)->format('F d, Y') }}', '{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '' }}')"
                             alt="Time In"
                             title="Click to view">
                    @else
                        <span class="no-photo-badge">No Photo</span>
                    @endif
                </td>
                <td>
                    {{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : ($hasApprovedAppeal ? 'Present (Appeal)' : '—') }}
                </td>
                <td class="photo-cell">
                    @if($attendance->time_out_photo)
                        <img src="{{ asset('storage/' . $attendance->time_out_photo) }}"
                             class="photo-thumbnail"
                             onclick="openPhotoModal('{{ asset('storage/' . $attendance->time_out_photo) }}', 'Time Out', '{{ \Carbon\Carbon::parse($attendance->date)->format('F d, Y') }}', '{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '' }}')"
                             alt="Time Out"
                             title="Click to view">
                    @else
                        <span class="no-photo-badge">No Photo</span>
                    @endif
                </td>

                <td class="photo-cell">
                    @if($attendance->overtime_photo)
                        <img src="{{ asset('storage/' . $attendance->overtime_photo) }}"
                             class="photo-thumbnail"
                             onclick="openPhotoModal('{{ asset('storage/' . $attendance->overtime_photo) }}', 'Overtime', '{{ \Carbon\Carbon::parse($attendance->date)->format('F d, Y') }}', '')"
                             alt="Overtime"
                             title="Click to view">
                    @else
                        <span class="no-photo-badge">-</span>
                    @endif
                </td>

                 <td>{{ number_format($attendance->student->accumulated_hours, 2) }} hrs</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No attendance records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="pagination-wrapper">
    {{ $attendances->withQueryString()->links('vendor.pagination.prev-next-only') }}
</div>

<!-- Photo Modal -->
<div id="photoModal" class="photo-modal" onclick="closePhotoModal()">
    <span class="photo-modal-close" onclick="closePhotoModal()">&times;</span>
    <img id="modalImage" class="photo-modal-content" onclick="event.stopPropagation()">
    <div id="modalInfo" class="photo-modal-info" onclick="event.stopPropagation()"></div>
</div>

<script>
function openPhotoModal(imageSrc, action, date, time) {
    document.getElementById('photoModal').classList.add('active');
    document.getElementById('modalImage').src = imageSrc;

    let info = '<strong>' + action + '</strong><br>' + date;
    if (time) {
        info += ' at ' + time;
    }

    document.getElementById('modalInfo').innerHTML = info;
    document.body.style.overflow = 'hidden';
}

function closePhotoModal() {
    document.getElementById('photoModal').classList.remove('active');
    document.body.style.overflow = '';
}

// Close on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePhotoModal();
    }
});
</script>

@endsection
