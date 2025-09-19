@extends('layouts.student')

@section('content')
<style>

    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .appeals-container {
        background: #ffffff;
        min-height: 100vh;
        padding: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #107936;
        text-align: center;
    }


    .success-alert {
        background: #dcfce7;
        border: 1px solid #22c55e;
        color: #15803d;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        border-radius: 12px;
        font-weight: 500;
    }


    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
    }

    .modern-table thead th {
        padding: 1.25rem;
        color: white;
        font-weight: 600;
        text-align: left;
        font-size: 0.875rem;
    }

    .modern-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.3s ease;
    }

    .modern-table tbody tr:hover {
        background: #f8fafc;
    }

    .modern-table tbody td {
        padding: 1.25rem;
        color: #475569;
        font-size: 0.875rem;
    }


    .status-pending { color: #d97706; font-weight: 600; }
    .status-approved { color: #16a34a; font-weight: 600; }
    .status-rejected { color: #dc2626; font-weight: 600; }


    .reject-box {
        background: #fef2f2;
        color: #dc2626;
        padding: 0.75rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        border-left: 3px solid #dc2626;
        max-width: 250px;
    }


    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #374151;
        margin: 2rem 0 1.5rem 0;
    }

    .attendance-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .attendance-item:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        border-color: #107936;
    }

    .attendance-details {
        flex: 1;
    }

    .attendance-date {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .attendance-times {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .appeal-button {
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
        color: white;
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(16, 121, 54, 0.2);
    }

    .appeal-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 121, 54, 0.3);
        background: linear-gradient(135deg, #0f6a2f 0%, #0d5a28 100%);
    }

    .attachment-link {
        color: #107936;
        text-decoration: none;
        font-weight: 500;
    }

    .attachment-link:hover {
        text-decoration: underline;
    }

    .empty-message {
        text-align: center;
        padding: 3rem 2rem;
        color: #6b7280;
        font-size: 1rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }


    @media (max-width: 768px) {
        .appeals-container {
            padding: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .attendance-item {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.75rem;
            font-size: 0.8125rem;
        }
    }
</style>

<div class="appeals-container">
    <h2 class="page-title">My Attendance Appeals</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="success-alert">
            {{ session('success') }}
        </div>
    @endif

    @if($appeals->isEmpty())
        <div class="empty-message">
            <p style="margin-bottom:1rem; font-weight: 600; color: #374151;">No appeals submitted yet.</p>

            @if($attendances->isNotEmpty())
                <p style="margin-bottom:1.5rem; color:#6b7280;">Choose an attendance record to submit an appeal for:</p>

                @foreach($attendances as $attendance)
                    <div class="attendance-item">
                        <div class="attendance-details">
                            <div class="attendance-date">
                                {{ $attendance->date ?? $attendance->created_at->toDateString() }}
                            </div>
                            <div class="attendance-times">
                                Time In: {{ $attendance->time_in ?? '—' }} | Time Out: {{ $attendance->time_out ?? '—' }}
                            </div>
                        </div>
                        <a href="{{ route('student.attendance-appeals.create', $attendance->id) }}" class="appeal-button">
                           Submit Appeal
                        </a>
                    </div>
                @endforeach
            @else
                <p style="color:#9ca3af; margin-top:1rem;">No attendance records available to appeal.</p>
            @endif
        </div>
    @else
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Reason</th>
                    <th>Attachment</th>
                    <th>Status</th>
                    <th>Reject Reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appeals as $appeal)
                    <tr>
                        <td><strong>{{ $appeal->attendance->date ?? $appeal->attendance->created_at->toDateString() }}</strong></td>
                        <td>{{ $appeal->attendance->time_in ?? '—' }}</td>
                        <td>{{ $appeal->attendance->time_out ?? '—' }}</td>
                        <td>{{ $appeal->reason }}</td>
                        <td>
                            @if($appeal->attachment)
                                <a href="{{ asset('storage/'.$appeal->attachment) }}" target="_blank" class="attachment-link">View</a>
                            @else
                                <span style="color: #9ca3af;">None</span>
                            @endif
                        </td>
                        <td class="status-{{ $appeal->status }}">
                            {{ ucfirst($appeal->status) }}
                        </td>
                        <td>
                            @if($appeal->status === 'rejected')
                                <div class="reject-box">
                                    {{ $appeal->reject_reason }}
                                </div>
                            @else
                                <span style="color:#9ca3af;">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        @if($attendances->isNotEmpty())
            <h3 class="section-title">Attendance Records You Can Appeal</h3>

            @foreach($attendances as $attendance)
                <div class="attendance-item">
                    <div class="attendance-details">
                        <div class="attendance-date">
                            {{ $attendance->date ?? $attendance->created_at->toDateString() }}
                        </div>
                        <div class="attendance-times">
                            Time In: {{ $attendance->time_in ?? '—' }} | Time Out: {{ $attendance->time_out ?? '—' }}
                        </div>
                    </div>
                    <a href="{{ route('student.attendance-appeals.create', $attendance->id) }}" class="appeal-button">
                       Submit Appeal
                    </a>
                </div>
            @endforeach
        @else
            <div class="empty-message">
                <p style="color:#9ca3af;">No attendance records available to appeal.</p>
            </div>
        @endif
    @endif
</div>
@endsection
