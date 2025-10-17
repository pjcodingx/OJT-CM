@extends('layouts.company')

@section('content')
<style>
    .container {
        max-width: 1400px;
        margin: 15px auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        font-family: 'Segoe UI', sans-serif;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #14532d;
        text-align: center;
    }

    .filter-form {
        display: flex;
        gap: 20px;
        align-items: end;
        margin-bottom: 20px;
        color: black;
    }

    .filter-form input[type="date"] {
        padding: 6px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .filter-form button {
        padding: 8px 16px;
        background-color: #14532d;
        color: white;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .filter-form button:hover {
        background-color: #1c6b3d;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        margin-top: 10px;
    }

    th, td {
        padding: 10px;
        border-bottom: 1px solid #ccc;
        text-align: left;
    }

    td {
        color: black;
    }

    th {
        background-color: #14532d;
        color: white;
    }

    tbody tr:hover {
        background-color: #d1e7dd;
    }

    /* Photo Styles */
    .photo-thumbnail {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 2px solid #ddd;
        transition: all 0.2s;
    }

    .photo-thumbnail:hover {
        transform: scale(1.15);
        border-color: #14532d;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .no-photo-badge {
        display: inline-block;
        padding: 3px 8px;
        background: #f8d7da;
        color: #721c24;
        border-radius: 4px;
        font-size: 11px;
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

    /* Pagination */
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

    .no-data {
        color: red;
        font-style: italic;
        padding: 10px 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        table {
            font-size: 12px;
        }

        th, td {
            padding: 6px;
        }

        .photo-thumbnail {
            width: 40px;
            height: 40px;
        }

        .photo-modal-close {
            right: 15px;
            font-size: 35px;
        }
    }
</style>

<div class="container">
    <h2>Attendance Logs</h2>

    <form method="GET" class="filter-form">
        <div>
            <label for="start_date">Start Date</label><br>
            <input type="date" name="start_date" value="{{ $startDate }}">
        </div>
        <div>
            <label for="end_date">End Date</label><br>
            <input type="date" name="end_date" value="{{ $endDate }}">
        </div>
        <button type="submit">Filter</button>
    </form>

    @if ($attendances->count())
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Student</th>
                    <th>Time In</th>
                    <th>Time In Photo</th>
                    <th>Time Out</th>
                    <th>Time Out Photo</th>
                    <th>Total Hours</th>
                    <th>OT Photo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                        <td>{{ $attendance->student->name }}</td>
                        <td>{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}</td>
                        <td class="photo-cell">
                            @if($attendance->time_in_photo)
                                <img src="{{ asset('storage/' . $attendance->time_in_photo) }}"
                                     class="photo-thumbnail"
                                     onclick="openPhotoModal('{{ asset('storage/' . $attendance->time_in_photo) }}', '{{ $attendance->student->name }}', 'Time In', '{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}', '{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '' }}')"
                                     alt="Time In Photo"
                                     title="Click to view full size">
                            @else
                                <span class="no-photo-badge">No Photo</span>
                            @endif
                        </td>
                        <td>{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}</td>
                        <td class="photo-cell">
                            @if($attendance->time_out_photo)
                                <img src="{{ asset('storage/' . $attendance->time_out_photo) }}"
                                     class="photo-thumbnail"
                                     onclick="openPhotoModal('{{ asset('storage/' . $attendance->time_out_photo) }}', '{{ $attendance->student->name }}', 'Time Out', '{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}', '{{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '' }}')"
                                     alt="Time Out Photo"
                                     title="Click to view full size">
                            @else
                                <span class="no-photo-badge">No Photo</span>
                            @endif
                        </td>
                        <td>{{ number_format($attendance->total_hours, 2) }} hrs</td>
                        <td class="photo-cell">
                            @if($attendance->overtime_photo)
                                <img src="{{ asset('storage/' . $attendance->overtime_photo) }}"
                                     class="photo-thumbnail"
                                     onclick="openPhotoModal('{{ asset('storage/' . $attendance->overtime_photo) }}', '{{ $attendance->student->name }}', 'Overtime', '{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}', '')"
                                     alt="Overtime Photo"
                                     title="Click to view full size">
                            @else
                                <span class="no-photo-badge">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $attendances->withQueryString()->links('vendor.pagination.prev-next-only') }}
        </div>
    @else
        <p class="no-data">No attendance records found for the selected date range.</p>
    @endif
</div>

<!-- Photo Modal -->
<div id="photoModal" class="photo-modal" onclick="closePhotoModal()">
    <span class="photo-modal-close" onclick="closePhotoModal()">&times;</span>
    <img id="modalImage" class="photo-modal-content" onclick="event.stopPropagation()">
    <div id="modalInfo" class="photo-modal-info" onclick="event.stopPropagation()"></div>
</div>

<script>
function openPhotoModal(imageSrc, studentName, action, date, time) {
    document.getElementById('photoModal').classList.add('active');
    document.getElementById('modalImage').src = imageSrc;

    let info = '<strong>' + studentName + '</strong><br>' + action + ' - ' + date;
    if (time) {
        info += ' at ' + time;
    }

    document.getElementById('modalInfo').innerHTML = info;
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closePhotoModal() {
    document.getElementById('photoModal').classList.remove('active');
    document.body.style.overflow = ''; // Restore scrolling
}

// Close modal on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePhotoModal();
    }
});

// Prevent modal from closing when clicking on image
document.getElementById('modalImage').addEventListener('click', function(event) {
    event.stopPropagation();
});
</script>

@endsection
