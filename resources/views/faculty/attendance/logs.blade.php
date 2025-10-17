@extends('layouts.faculty')

@section('content')
<style>
.container {
    max-width: 1400px;
    margin: 40px auto;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.header-section {
    background-color: #14532d;
    padding: 24px 32px;
    border-radius: 8px 8px 0 0;
}

.header-section h2 {
    color: #fff;
    margin: 0;
    font-size: 24px;
    font-weight: 600;
}

.content-section {
    background-color: #fff;
    padding: 32px;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.filter-form {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
    align-items: end;
}

.filter-group {
    flex: 1;
}

.filter-group label {
    display: block;
    margin-bottom: 6px;
    color: #374151;
    font-weight: 500;
    font-size: 14px;
}

.filter-form input[type="date"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
}

.filter-form input[type="date"]:focus {
    outline: none;
    border-color: #14532d;
}

.filter-form button {
    padding: 10px 24px;
    background-color: #14532d;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    font-size: 14px;
}

.filter-form button:hover {
    background-color: #166534;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

thead {
    background-color: #14532d;
}

th {
    padding: 12px;
    color: white;
    font-weight: 600;
    text-align: left;
    font-size: 13px;
}

td {
    padding: 12px;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
}

tbody tr:hover {
    background-color: #f9fafb;
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
    border-color: #14532d;
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
    background-color: #14532d;
    color: #fff;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
}

.page-link:hover {
    background-color: #166534;
}

.page-item.disabled .page-link {
    background-color: #d1d5db;
    cursor: not-allowed;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #dc2626;
    font-style: italic;
}

@media (max-width: 768px) {
    .container {
        margin: 20px;
    }

    .filter-form {
        flex-direction: column;
    }

    .filter-form button {
        width: 100%;
    }

    table {
        font-size: 12px;
    }

    th, td {
        padding: 8px;
    }

    .photo-thumbnail {
        width: 35px;
        height: 35px;
    }

    .photo-modal-close {
        right: 15px;
        font-size: 35px;
    }
}
</style>

<div class="container">
    <div class="header-section">
        <h2>Attendance Logs</h2>
    </div>

    <div class="content-section">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="filter-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}">
            </div>
            <button type="submit">Filter</button>
        </form>

        @if ($attendances->count())
        <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>In Photo</th>
                    <th>Time Out</th>
                    <th>Out Photo</th>
                    <th>Hours</th>
                    <th>OT Photo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->student->name }}</td>
                    <td>{{ $attendance->student->email }}</td>
                    <td>{{ $attendance->student->company->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                    <td>{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}</td>
                    <td class="photo-cell">
                        @if($attendance->time_in_photo)
                            <img src="{{ asset('storage/' . $attendance->time_in_photo) }}"
                                 class="photo-thumbnail"
                                 onclick="openPhotoModal('{{ asset('storage/' . $attendance->time_in_photo) }}', '{{ $attendance->student->name }}', 'Time In', '{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}', '{{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '' }}')"
                                 alt="Time In"
                                 title="Click to view">
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
                                 alt="Time Out"
                                 title="Click to view">
                        @else
                            <span class="no-photo-badge">No Photo</span>
                        @endif
                    </td>
                    <td>{{ number_format($attendance->student->accumulated_hours, 2) }} hrs</td>
                    <td class="photo-cell">
                        @if($attendance->overtime_photo)
                            <img src="{{ asset('storage/' . $attendance->overtime_photo) }}"
                                 class="photo-thumbnail"
                                 onclick="openPhotoModal('{{ asset('storage/' . $attendance->overtime_photo) }}', '{{ $attendance->student->name }}', 'Overtime', '{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}', '')"
                                 alt="Overtime"
                                 title="Click to view">
                        @else
                            <span class="no-photo-badge">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <div class="pagination-wrapper">
            {{ $attendances->withQueryString()->links('vendor.pagination.prev-next-only') }}
        </div>
        @else
            <p class="no-data">No attendance logs found!</p>
        @endif
    </div>
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
