@extends('layouts.company')

@section('content')
<div style="background:#f8fafb; min-height:100vh; padding:32px 24px;">

    <div style="max-width:1400px; margin:0 auto;">

        <!-- Header Section -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div>
                <h1 style="font-size:28px; margin:0 0 4px 0; color:#0f172a; font-weight:700;">Attendance Appeals</h1>
                <p style="margin:0; color:#64748b; font-size:14px;">Review and manage trainee attendance appeals</p>
            </div>

            @if(session('success'))
                <div style="background:#ecfdf5; color:#065f46; padding:12px 16px; border-radius:8px; border:1px solid #a7f3d0; font-weight:500;">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Main Content Card -->
        <div style="background:#ffffff; border-radius:16px; box-shadow:0 1px 3px rgba(0,0,0,0.08); overflow:hidden;">

            <!-- Card Header -->
            <div style="padding:20px 24px; border-bottom:2px solid #f1f5f9; background:#fafbfc;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div style="font-weight:600; color:#1e293b; font-size:16px;">Pending Appeals</div>
                    <div style="background:#fff7ed; color:#c2410c; padding:6px 12px; border-radius:6px; font-size:13px; font-weight:600;">
                        <span style="color:#9ca3af;">Status:</span> Pending Review
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#1b681b; color:#f1f5f9;">
                            <th style="padding:14px 16px; text-align:left; font-weight:600; font-size:13px; letter-spacing:0.3px;">STUDENT</th>
                            <th style="padding:14px 16px; text-align:left; font-weight:600; font-size:13px; letter-spacing:0.3px;">DATE</th>
                            <th style="padding:14px 16px; text-align:left; font-weight:600; font-size:13px; letter-spacing:0.3px;">TIME</th>
                            <th style="padding:14px 16px; text-align:left; font-weight:600; font-size:13px; letter-spacing:0.3px; min-width:280px;">REASON</th>
                            <th style="padding:14px 16px; text-align:center; font-weight:600; font-size:13px; letter-spacing:0.3px;">ATTACHMENT</th>
                            <th style="padding:14px 16px; text-align:center; font-weight:600; font-size:13px; letter-spacing:0.3px;">STATUS</th>
                            <th style="padding:14px 16px; text-align:center; font-weight:600; font-size:13px; letter-spacing:0.3px;">ACTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($appeals as $appeal)
                            <tr style="border-bottom:1px solid #f1f5f9; transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">

                                <!-- Student -->
                                <td style="padding:16px; vertical-align:top;">
                                    <div style="font-weight:600; color:#0f172a; font-size:15px;">{{ $appeal->attendance->student->name ?? 'N/A' }}</div>
                                </td>

                                <!-- Date -->
                                <td style="padding:16px; vertical-align:top;">
                                    <div style="font-weight:600; color:#0f172a; font-size:14px;">{{ $appeal->attendance->date ?? $appeal->attendance->created_at->toDateString() }}</div>
                                    <div style="font-size:12px; color:#94a3b8; margin-top:2px;">Submitted: {{ $appeal->created_at->format('M d, Y h:i A') }}</div>
                                </td>

                                <!-- Time In/Out -->
                                <td style="padding:16px; vertical-align:top;">
                                    <div style="display:flex; flex-direction:column; gap:4px;">
                                        <div style="font-size:13px;">
                                            <span style="color:#64748b; font-weight:500;">In:</span>
                                            <span style="color:#0f172a; font-weight:600;">{{ $appeal->attendance->time_in ?? '—' }}</span>
                                        </div>
                                        <div style="font-size:13px;">
                                            <span style="color:#64748b; font-weight:500;">Out:</span>
                                            <span style="color:#0f172a; font-weight:600;">{{ $appeal->attendance->time_out ?? '—' }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Reason - Full text visible -->
                                <td style="padding:16px; vertical-align:top;">
                                    <div style="color:#334155; line-height:1.6; font-size:14px; max-width:320px; word-wrap:break-word;">
                                        {{ $appeal->reason }}
                                    </div>
                                </td>

                                <!-- Attachment -->
                                <td style="padding:16px; vertical-align:top; text-align:center;">
                                    @if($appeal->attachment)
                                        <a href="{{ asset('storage/'.$appeal->attachment) }}" target="_blank"
                                           style="display:inline-flex; align-items:center; gap:4px; background:#ecfdf5; color:#059669; padding:6px 12px; border-radius:6px; text-decoration:none; font-weight:600; font-size:13px; border:1px solid #a7f3d0;">
                                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
                                            </svg>
                                            View
                                        </a>
                                    @else
                                        <span style="color:#cbd5e1; font-size:13px; font-weight:500;">No file</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td style="padding:16px; vertical-align:top; text-align:center;">
                                    @if($appeal->status === 'pending')
                                        <span style="background:#fef3c7; color:#92400e; padding:6px 14px; border-radius:20px; font-weight:600; font-size:12px; display:inline-block; border:1px solid #fde68a;">Pending</span>
                                    @elseif($appeal->status === 'approved')
                                        <span style="background:#d1fae5; color:#065f46; padding:6px 14px; border-radius:20px; font-weight:600; font-size:12px; display:inline-block; border:1px solid #a7f3d0;">Approved</span>
                                    @else
                                        <span style="background:#fee2e2; color:#991b1b; padding:6px 14px; border-radius:20px; font-weight:600; font-size:12px; display:inline-block; border:1px solid #fecaca;">Rejected</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td style="padding:16px; vertical-align:top;">
                                    <div style="display:flex; flex-direction:column; gap:8px; align-items:center; min-width:200px;">

                                        <!-- Action Buttons -->
                                        <div style="display:flex; gap:6px; justify-content:center;">
                                            <button type="button" class="btn-approve" data-id="{{ $appeal->id }}"
                                                    style="background:#059669; color:#fff; border:none; padding:8px 16px; border-radius:6px; cursor:pointer; font-weight:600; font-size:13px; transition:background 0.2s;"
                                                    onmouseover="this.style.background='#047857'" onmouseout="this.style.background='#059669'">
                                                ✓ Approve
                                            </button>

                                            <button type="button" class="btn-reject" data-id="{{ $appeal->id }}"
                                                    style="background:#dc2626; color:#fff; border:none; padding:8px 16px; border-radius:6px; cursor:pointer; font-weight:600; font-size:13px; transition:background 0.2s;"
                                                    onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                                                ✕ Reject
                                            </button>
                                        </div>

                                        <!-- Approve Form -->
                                        <form method="POST" action="{{ route('company.attendance-appeals.approve', $appeal->id) }}" class="approve-form" id="approve-form-{{ $appeal->id }}" style="display:none; width:100%;">
                                            @csrf
                                            <div style="background:#f0fdf4; padding:12px; border-radius:8px; border:1px solid #bbf7d0;">
                                                <label style="display:block; font-size:12px; color:#065f46; font-weight:600; margin-bottom:6px;">Credited Hours</label>
                                                <input type="number" name="credited_hours" step="0.01" min="0" placeholder="0.00" max="10"
                                                       style="width:100%; padding:8px; border-radius:6px; border:1px solid #86efac; font-size:14px; margin-bottom:8px;" required>
                                                <div style="display:flex; gap:6px;">
                                                    <button type="submit" style="flex:1; background:#16a34a; color:#fff; border:none; padding:8px; border-radius:6px; cursor:pointer; font-weight:600; font-size:13px;">Confirm</button>
                                                    <button type="button" class="approve-cancel" data-id="{{ $appeal->id }}" style="flex:1; background:#e5e7eb; border:none; padding:8px; border-radius:6px; cursor:pointer; font-weight:600; font-size:13px; color:#64748b;">Cancel</button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- Reject Form -->
                                        <form method="POST" action="{{ route('company.attendance-appeals.reject', $appeal->id) }}" class="reject-form" id="reject-form-{{ $appeal->id }}" style="display:none; width:100%;">
                                            @csrf
                                            <div style="background:#fef2f2; padding:12px; border-radius:8px; border:1px solid #fecaca;">
                                                <label style="display:block; font-size:12px; color:#991b1b; font-weight:600; margin-bottom:6px;">Rejection Reason</label>
                                                <textarea name="reject_reason" rows="3" placeholder="Please provide a reason..."
                                                          style="width:100%; padding:8px; border-radius:6px; border:1px solid #fca5a5; font-size:13px; margin-bottom:8px; resize:vertical;" required></textarea>
                                                <div style="display:flex; gap:6px;">
                                                    <button type="submit" style="flex:1; background:#dc2626; color:#fff; border:none; padding:8px; border-radius:6px; cursor:pointer; font-weight:600; font-size:13px;">Reject</button>
                                                    <button type="button" class="reject-cancel" data-id="{{ $appeal->id }}" style="flex:1; background:#e5e7eb; border:none; padding:8px; border-radius:6px; cursor:pointer; font-weight:600; font-size:13px; color:#64748b;">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:48px; text-align:center;">
                                    <div style="color:#94a3b8; font-size:15px;">
                                        <div style="font-size:48px; margin-bottom:12px;">📋</div>
                                        <div style="font-weight:600; color:#64748b; margin-bottom:4px;">No Pending Appeals</div>
                                        <div style="font-size:13px;">All attendance appeals have been reviewed.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.btn-approve').forEach(function(btn){
            btn.addEventListener('click', function(){
                const id = this.dataset.id;
                const form = document.getElementById('approve-form-' + id);
                const rejectForm = document.getElementById('reject-form-' + id);
                if (form.style.display === 'none' || form.style.display === '') {
                    form.style.display = 'block';
                    if (rejectForm) rejectForm.style.display = 'none';
                } else {
                    form.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('.btn-reject').forEach(function(btn){
            btn.addEventListener('click', function(){
                const id = this.dataset.id;
                const form = document.getElementById('reject-form-' + id);
                const approveForm = document.getElementById('approve-form-' + id);
                if (form.style.display === 'none' || form.style.display === '') {
                    form.style.display = 'block';
                    if (approveForm) approveForm.style.display = 'none';
                } else {
                    form.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('.approve-cancel').forEach(function(btn){
            btn.addEventListener('click', function(){
                const id = this.dataset.id;
                const form = document.getElementById('approve-form-' + id);
                if (form) form.style.display = 'none';
            });
        });

        document.querySelectorAll('.reject-cancel').forEach(function(btn){
            btn.addEventListener('click', function(){
                const id = this.dataset.id;
                const form = document.getElementById('reject-form-' + id);
                if (form) form.style.display = 'none';
            });
        });
    });
</script>

@endsection
