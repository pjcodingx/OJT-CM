@extends('layouts.student')

@section('content')
<style>
    :root {
        --primary-green: #2d6a4f;
        --light-green: #52b788;
        --border-color: #dee2e6;
        --text-dark: #212529;
        --text-muted: #6c757d;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--primary-green);
    }

    .page-title {
        color: var(--primary-green);
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
    }

    .btn-new-request {
        background: var(--primary-green);
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: background 0.2s ease;
        cursor: pointer;
    }

    .btn-new-request:hover {
        background: var(--light-green);
    }

    .modern-card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .table-container {
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        margin: 0;
        border-collapse: collapse;
    }

    .modern-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid var(--primary-green);
    }

    .modern-table thead th {
        color: var(--text-dark);
        font-weight: 600;
        padding: 1rem;
        text-align: left;
        font-size: 0.9rem;
    }

    .modern-table tbody tr {
        border-bottom: 1px solid var(--border-color);
        transition: background 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #f8f9fa;
    }

    .modern-table tbody td {
        padding: 1rem;
        color: var(--text-dark);
        font-size: 0.9rem;
    }

    .status-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-block;
    }

    .badge-approved {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .badge-rejected {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .badge-pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--text-muted);
        opacity: 0.5;
        margin-bottom: 1rem;
    }

    .text-muted-custom {
        color: var(--text-muted);
    }

    /* Modal Styles */
    .modal-content-custom {
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .modal-header-custom {
        background: var(--primary-green);
        color: white;
        border-bottom: none;
        padding: 1.25rem 1.5rem;
        border-radius: 8px 8px 0 0;
    }

    .modal-title-custom {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .modal-body-custom {
        padding: 1.5rem;
    }

    .modal-body-custom p {
        color: var(--text-dark);
        font-size: 0.95rem;
        margin: 0;
    }

    .modal-footer-custom {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 6px;
        font-weight: 500;
        transition: background 0.2s ease;
    }

    .btn-cancel:hover {
        background: #5a6268;
    }

    .btn-submit {
        background: var(--primary-green);
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 6px;
        font-weight: 500;
        transition: background 0.2s ease;
    }

    .btn-submit:hover {
        background: var(--light-green);
    }

    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .btn-new-request {
            width: 100%;
            justify-content: center;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 0.75rem;
            font-size: 0.85rem;
        }
    }

    .badge-completed {
    background-color: #28a745;
    color: #fff;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
}

</style>

<div class="container mt-4">
    <div class="header-section">
        <h4 class="page-title">Overtime Requests</h4>

    </div>

    {{-- ✅ Flash Messages --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert"
         style="background:#d4edda;color:#155724;border:1px solid #c3e6cb;border-radius:6px;padding:0.75rem 1rem;margin-bottom:1rem;">
       {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert"
         style="background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;border-radius:6px;padding:0.75rem 1rem;margin-bottom:1rem;">
         {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


    <div class="modern-card">
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Date Requested</th>
                        <th>Approved Hours</th>
                        <th>Status</th>
                        <th>Scan Start</th>
                        <th>Scan End</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $req)
                        <tr>
                            <td>{{ $req->created_at->format('F d, Y h:i A') }}</td>
                            <td>{{ $req->approved_hours ?? '--' }}</td>
                            <td>
                               @if ($req->status === 'approved')
                                    <span class="status-badge badge-approved">Approved</span>
                                @elseif ($req->status === 'completed')
                                    <span class="status-badge badge-completed">Completed</span>
                                @elseif ($req->status === 'rejected')
                                    <span class="status-badge badge-rejected">Rejected</span>
                                @else
                                    <span class="status-badge badge-pending">Pending</span>
                                @endif

                            </td>
                            <td>{{ $req->scan_start ? \Carbon\Carbon::parse($req->scan_start)->format('h:i A') : '--' }}</td>
                            <td>{{ $req->scan_end ? \Carbon\Carbon::parse($req->scan_end)->format('h:i A') : '--' }}</td>
                            <td class="text-muted-custom">{{ $req->remarks ?? '--' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-clock"></i>
                                    <p>No overtime requests yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createOvertimeModal" tabindex="-1" aria-labelledby="createOvertimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('student.overtime.store') }}" method="POST">
            @csrf
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title modal-title-custom" id="createOvertimeModalLabel">New Overtime Request</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modal-body-custom">
                    <p>Are you sure you want to submit a new overtime request?</p>
                </div>
                <div class="modal-footer modal-footer-custom">
                    <button type="submit" class="btn-submit">Submit Request</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
