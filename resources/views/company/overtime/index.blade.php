@extends('layouts.company')

@section('content')
<style>
:root {
    --primary-green: #2d6a4f;
    --light-green: #52b788;
    --accent-green: #40916c;
    --hover-green: #1b4332;
    --bg-light: #f8f9fa;
    --shadow-sm: 0 2px 4px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 12px rgba(0,0,0,0.12);
    --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.overtime-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
    background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
    min-height: 100vh;
}

.page-header {
    margin-bottom: 2rem;
    animation: fadeInDown 0.6s ease;
}

.page-title {
    color: var(--primary-green);
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
}

.page-subtitle {
    color: #6c757d;
    font-size: 0.95rem;
    font-weight: 400;
}

/* Alert Styling */
.alert-custom {
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid;
    background: white;
    box-shadow: var(--shadow-sm);
    animation: slideInRight 0.5s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-success-custom {
    border-left-color: #28a745;
    background: linear-gradient(to right, #d4edda 0%, #ffffff 100%);
    color: #28a745;
}

.alert-icon {
    font-size: 1.5rem;
}

/* Card Styling */
.requests-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    overflow: hidden;
    animation: fadeInUp 0.6s ease;
}

/* Table Styling */
.table-container {
    padding: 1.5rem;
    overflow-x: auto;
}

.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.9rem;
}

.custom-table thead {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-green) 100%);
}

.custom-table thead th {
    padding: 1rem 0.75rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--accent-green);
    white-space: nowrap;
}

.custom-table tbody tr {
    transition: var(--transition);
    border-bottom: 1px solid #e9ecef;
}

.custom-table tbody tr:hover {
    background: #f8f9fa;
    transform: scale(1.005);
    box-shadow: var(--shadow-sm);
}

.custom-table tbody td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    color: #495057;
}

/* Status Badges */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
}

.badge-approved {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border: 1px solid #b1dfbb;
}

.badge-rejected {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border: 1px solid #f1b0b7;
}

.badge-pending {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
    color: #856404;
    border: 1px solid #ffe8a1;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn-action {
    padding: 0.5rem 1.2rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.btn-approve {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-green) 100%);
    color: white;
}

.btn-approve:hover {
    background: linear-gradient(135deg, var(--hover-green) 0%, var(--primary-green) 100%);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-reject {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.btn-reject:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Modal Styling - Pure CSS */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-overlay.active {
    display: flex;
    opacity: 1;
}

.modal-content {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    width: 90%;
    max-width: 500px;
    transform: scale(0.9);
    transition: transform 0.3s ease;
    color: black;

}

.modal-overlay.active .modal-content {
    transform: scale(1);
}

.modal-header-custom {
    padding: 1.5rem;
    color: white;
    border: none;
}

.modal-header-approve {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-green) 100%);
}

.modal-header-reject {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.modal-title-custom {
    font-weight: 600;
    font-size: 1.3rem;
    display: flex;
    justify-content: space-between;
    align-items: center;

}

.modal-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.3s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.modal-body-custom {
    padding: 2rem;
    background: #f8f9fa;
}

.form-group-custom {
    margin-bottom: 1.5rem;
}

.form-label-custom {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

.form-control-custom {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: var(--transition);
    background: white;
}

.form-control-custom:focus {
    outline: none;
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
}

.modal-footer-custom {
    padding: 1.5rem;
    background: white;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

.btn-modal {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    font-size: 0.95rem;
}

.btn-cancel {
    background: #6c757d;
    color: white;
}

.btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.btn-submit-approve {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-green) 100%);
    color: white;
}

.btn-submit-approve:hover {
    background: linear-gradient(135deg, var(--hover-green) 0%, var(--primary-green) 100%);
    transform: translateY(-2px);
}

.btn-submit-reject {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.btn-submit-reject:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-2px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #6c757d;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-text {
    font-size: 1.1rem;
    font-weight: 500;
}

/* Bulk Action Buttons */
.bulk-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
    flex-wrap: wrap;
}

.bulk-btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.bulk-approve {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-green) 100%);
    color: white;
}

.bulk-approve:hover {
    background: linear-gradient(135deg, var(--hover-green) 0%, var(--primary-green) 100%);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.bulk-reject {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.bulk-reject:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Animations */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .overtime-container {
        padding: 1rem;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn-action {
        width: 100%;
    }

    .custom-table {
        font-size: 0.8rem;
    }

    .custom-table thead th,
    .custom-table tbody td {
        padding: 0.75rem 0.5rem;
    }

    .modal-content {
        width: 95%;
        margin: 1rem;
    }

    .modal-footer-custom {
        flex-direction: column;
    }

    .btn-modal {
        width: 100%;
    }

    .bulk-actions {
        justify-content: center;
    }

    .bulk-btn {
        width: 100%;
        justify-content: center;
    }
}

.badge-completed {
    background-color: #28a745;
    color: #fff;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
}

</style>

<div class="overtime-container">
    <div class="page-header">
        <h1 class="page-title">⏰ Overtime Requests</h1>
        <p class="page-subtitle">Manage and approve student overtime requests</p>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert-custom alert-success-custom">
            <span class="alert-icon">✅</span>
            <div>
                <strong>Success!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close" onclick="this.parentElement.parentElement.style.display='none'" style="margin-left: auto; background: none; border: none; font-size: 1.2rem; cursor: pointer;">×</button>
        </div>
    @endif

    <div class="requests-card">
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Date Requested</th>
                        <th>Approved Hours</th>
                        <th>Scan Start</th>
                        <th>Scan End</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $req)
                        <tr>
                            <td><strong>{{ $req->student->name }}</strong></td>
                            <td>{{ $req->created_at->format('M d, Y h:i A') }}</td>
                            <td>{{ $req->approved_hours ?? '--' }}</td>
                            <td>{{ $req->scan_start ?? '--' }}</td>
                            <td>{{ $req->scan_end ?? '--' }}</td>
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
                            <td>{{ $req->remarks ?? '--' }}</td>
                            <td>
                                @if ($req->status === 'pending')
                                    <div class="action-buttons">
                                        <button type="button" class="btn-action btn-approve" onclick="openModal('approveModal{{ $req->id }}')">Approve</button>
                                        <button type="button" class="btn-action btn-reject" onclick="openModal('rejectModal{{ $req->id }}')">Reject</button>
                                    </div>
                                @else
                                    --
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <p class="empty-text">No overtime requests yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Bulk Action Buttons --}}
            @if ($requests->where('status', 'pending')->count() > 0)
                <div class="bulk-actions">
                    <button type="button" class="bulk-btn bulk-approve" onclick="openModal('approveAllModal')">
                        ✅ Approve All Pending
                    </button>
                    <button type="button" class="bulk-btn bulk-reject" onclick="openModal('rejectAllModal')">
                        ❌ Reject All Pending
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Individual Modals for Each Request --}}
@foreach ($requests as $req)
    @if ($req->status === 'pending')
        <!-- Approve Modal for Request {{ $req->id }} -->
        <div class="modal-overlay" id="approveModal{{ $req->id }}">
            <div class="modal-content">
                <form action="{{ route('company.overtime.approve', $req->id) }}" method="POST">
                    @csrf
                    <div class="modal-header-custom modal-header-approve">
                        <h5 class="modal-title-custom">
                            ✅ Approve Overtime Request
                            <button type="button" class="modal-close" onclick="closeModal('approveModal{{ $req->id }}')">×</button>
                        </h5>
                    </div>
                    <div class="modal-body-custom">
                        <p>You are approving overtime request for <strong>{{ $req->student->name }}</strong>.</p>
                        <div class="form-group-custom">
                            <label class="form-label-custom" style="margin-top: 6px;">Approved Hours *</label>
                            <input type="number" name="approved_hours" step="0.5" min="0.5" max="8" class="form-control-custom" value="{{ old('approved_hours') }}" required>
                            <small class="text-muted">Enter the number of approved overtime hours</small>
                        </div>
                        <div class="form-group-custom">
                            <label class="form-label-custom">Scan Start Time *</label>
                            <input type="time" name="scan_start" class="form-control-custom" value="{{ old('scan_start') }}" required>
                        </div>
                        <div class="form-group-custom">
                            <label class="form-label-custom">Scan End Time *</label>
                            <input type="time" name="scan_end" class="form-control-custom" value="{{ old('scan_end') }}" required>
                        </div>
                        <div class="form-group-custom">
                            <label class="form-label-custom">Remarks (Optional)</label>
                            <textarea name="remarks" class="form-control-custom" rows="3" placeholder="Add any additional notes...">{{ old('remarks') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal btn-cancel" onclick="closeModal('approveModal{{ $req->id }}')">Cancel</button>
                        <button type="submit" class="btn-modal btn-submit-approve">Approve Request</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reject Modal for Request {{ $req->id }} -->
        <div class="modal-overlay" id="rejectModal{{ $req->id }}">
            <div class="modal-content">
                <form action="{{ route('company.overtime.reject', $req->id) }}" method="POST">
                    @csrf
                    <div class="modal-header-custom modal-header-reject">
                        <h5 class="modal-title-custom">
                            ❌ Reject Overtime Request
                            <button type="button" class="modal-close" onclick="closeModal('rejectModal{{ $req->id }}')">×</button>
                        </h5>
                    </div>
                    <div class="modal-body-custom">
                        <p>You are rejecting overtime request for <strong>{{ $req->student->name }}</strong>.</p>
                        <div class="form-group-custom">
                            <label class="form-label-custom" style="margin-top: 10px;">Reason for Rejection *</label>
                            <textarea name="remarks" class="form-control-custom" rows="4" placeholder="Please provide a reason for rejection..." required>{{ old('remarks') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal btn-cancel" onclick="closeModal('rejectModal{{ $req->id }}')">Cancel</button>
                        <button type="submit" class="btn-modal btn-submit-reject">Reject Request</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endforeach

{{-- Approve All Modal --}}
<div class="modal-overlay" id="approveAllModal">
    <div class="modal-content">
        <form action="{{ route('company.overtime.approveAll') }}" method="POST">
            @csrf
            <div class="modal-header-custom modal-header-approve">
                <h5 class="modal-title-custom">
                    ✅ Approve All Pending Requests
                    <button type="button" class="modal-close" onclick="closeModal('approveAllModal')">×</button>
                </h5>
            </div>
            <div class="modal-body-custom">
                <p  style="margin-bottom: 10px;">Are you sure you want to approve <strong>all pending overtime requests</strong>?</p>
                <div class="form-group-custom">
                    <label class="form-label-custom">Approved Hours (applied to all)</label>
                    <input type="number" name="approved_hours" step="0.5" min="0.5" max="8" class="form-control-custom" required>
                </div>
                <div class="form-group-custom">
                    <label class="form-label-custom">Scan Start (HH:MM)</label>
                    <input type="time" name="scan_start" class="form-control-custom" required>
                </div>
                <div class="form-group-custom">
                    <label class="form-label-custom">Scan End (HH:MM)</label>
                    <input type="time" name="scan_end" class="form-control-custom" required>
                </div>
                <div class="form-group-custom">
                    <label class="form-label-custom">Remarks (optional)</label>
                    <textarea name="remarks" class="form-control-custom" rows="3" placeholder="Add any additional notes..."></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-modal btn-cancel" onclick="closeModal('approveAllModal')">Cancel</button>
                <button type="submit" class="btn-modal btn-submit-approve">Approve All</button>
            </div>
        </form>
    </div>
</div>

{{-- Reject All Modal --}}
<div class="modal-overlay" id="rejectAllModal">
    <div class="modal-content">
        <form action="{{ route('company.overtime.rejectAll') }}" method="POST">
            @csrf
            <div class="modal-header-custom modal-header-reject">
                <h5 class="modal-title-custom">
                    ❌ Reject All Pending Requests
                    <button type="button" class="modal-close" onclick="closeModal('rejectAllModal')">×</button>
                </h5>
            </div>
            <div class="modal-body-custom">
                <p  style="margin-bottom: 10px;">Are you sure you want to reject <strong>all pending overtime requests</strong>?</p>
                <div class="form-group-custom">
                    <label class="form-label-custom">Remarks (optional)</label>
                    <textarea name="remarks" class="form-control-custom" rows="3" placeholder="Provide a reason for rejection..."></textarea>
                </div>
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-modal btn-cancel" onclick="closeModal('rejectAllModal')">Cancel</button>
                <button type="submit" class="btn-modal btn-submit-reject">Reject All</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('active');
    document.body.style.overflow = 'hidden'; // Prevent scrolling
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('active');
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Close modal when clicking outside the modal content
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal-overlay')) {
        event.target.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal-overlay.active');
        modals.forEach(modal => {
            modal.classList.remove('active');
        });
        document.body.style.overflow = 'auto';
    }
});
</script>

@endsection
