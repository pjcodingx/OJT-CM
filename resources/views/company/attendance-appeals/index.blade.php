@extends('layouts.company') {{-- or layouts.app depending on your app --}}

@section('content')
<div style="background:#f3f7f6; min-height:100vh; padding:28px 20px;">

    <div style="max-width:1300px; margin:0 auto;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
            <h1 style="font-size:20px; margin:0; color:#063427; font-weight:700;">Attendance Appeals</h1>

            @if(session('success'))
                <div style="background:#ecfdf5; color:#065f46; padding:8px 12px; border-radius:8px; border:1px solid #bbf7d0;">
                    {{ session('success') }}
                </div>
            @endif
        </div>


        <div style="background:#ffffff; border-radius:12px; padding:18px; box-shadow:0 6px 18px rgba(6,40,30,0.06);">
            <div style="margin-bottom:12px;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div style="font-weight:600; color:#0b3e2e;">Pending appeals for your trainees</div>
                    <div style="color:#6b7280; font-size:13px;">Showing: <strong style="color:#0b3e2e;">Pending</strong></div>
                </div>
            </div>


            <div style="overflow:auto;">
                <table style="width:100%; border-collapse:collapse; min-width:900px;">
                    <thead>
                        <tr style="background:#1b681b; color:#e4e4e4; text-align:left;">
                            <th style="padding:12px 10px; border-bottom:1px solid #eef2f1; font-weight:600;">Student</th>
                            <th style="padding:12px 10px; border-bottom:1px solid #eef2f1; font-weight:600;">Date</th>
                            <th style="padding:12px 10px; border-bottom:1px solid #eef2f1; font-weight:600;">Time In / Out</th>
                            <th style="padding:12px 10px; border-bottom:1px solid #eef2f1; font-weight:600;">Reason</th>
                            <th style="padding:12px 10px; border-bottom:1px solid #eef2f1; font-weight:600;">Attachment</th>
                            <th style="padding:12px 10px; border-bottom:1px solid #eef2f1; font-weight:600;">Status</th>
                            <th style="padding:12px 10px; border-bottom:1px solid #eef2f1; font-weight:600; text-align:center;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($appeals as $appeal)
                            <tr style="border-bottom:1px solid #f1f6f5;">
                                <td style="padding:12px 10px; vertical-align:top;">
                                    <div style="font-weight:600; color:#063427;">{{ $appeal->attendance->student->name ?? 'N/A' }}</div>
                                    {{-- <div style="font-size:12px; color:#6b7280;">Student ID: {{ $appeal->attendance->student->student_number ?? '—' }}</div> --}}
                                </td>

                                <td style="padding:12px 10px; vertical-align:top; color: #063427;">
                                    <div style="font-weight:600;">{{ $appeal->attendance->date ?? $appeal->attendance->created_at->toDateString() }}</div>
                                    <div style="font-size:12px; color:#6b7280;">Submitted: {{ $appeal->created_at->toDateTimeString() }}</div>
                                </td>

                                <td style="padding:12px 10px; vertical-align:top; color: #063427;">
                                    <div style="font-weight:600;">{{ $appeal->attendance->time_in ?? '—' }}</div>
                                    <div style="font-size:12px; color:#6b7280;">{{ $appeal->attendance->time_out ?? '—' }}</div>
                                </td>

                                <td style="padding:12px 10px; vertical-align:top; max-width:240px;">
                                    <div style="color:#0b3e2e;">{{ Str::limit($appeal->reason, 160) }}</div>
                                </td>

                                <td style="padding:12px 10px; vertical-align:top;">
                                    @if($appeal->attachment)
                                        <a href="{{ asset('storage/'.$appeal->attachment) }}" target="_blank" style="color:#065f46; text-decoration:underline; font-weight:600;">View</a>
                                    @else
                                        <span style="color:#9ca3af;">None</span>
                                    @endif
                                </td>

                                <td style="padding:12px 10px; vertical-align:top;">
                                    @if($appeal->status === 'pending')
                                        <span style="background:#fffbeb; color:#92400e; padding:6px 8px; border-radius:999px; font-weight:600; font-size:13px; display:inline-block;">Pending</span>
                                    @elseif($appeal->status === 'approved')
                                        <span style="background:#ecfdf5; color:#065f46; padding:6px 8px; border-radius:999px; font-weight:600; font-size:13px; display:inline-block;">Approved</span>
                                    @else
                                        <span style="background:#fef2f2; color:#991b1b; padding:6px 8px; border-radius:999px; font-weight:600; font-size:13px; display:inline-block;">Rejected</span>
                                    @endif
                                </td>

                                <td style="padding:12px 10px; vertical-align:top; text-align:center;">

                                    <div style="display:flex; gap:8px; justify-content:center;">


                                        <button type="button" class="btn-approve" data-id="{{ $appeal->id }}" style="background:#0b3e2e; color:#fff; border:none; padding:8px 10px; border-radius:6px; cursor:pointer; font-weight:600;">
                                            Approve
                                        </button>


                                        <button type="button" class="btn-reject" data-id="{{ $appeal->id }}" style="background:#ef4444; color:#fff; border:none; padding:8px 10px; border-radius:6px; cursor:pointer; font-weight:600;">
                                            Reject
                                        </button>
                                    </div>


                                    <form method="POST" action="{{ route('company.attendance-appeals.approve', $appeal->id) }}" class="approve-form" id="approve-form-{{ $appeal->id }}" style="display:none; margin-top:10px;">
                                        @csrf
                                        <div style="display:flex; gap:6px; justify-content:center; align-items:center;">
                                            <input type="number" name="credited_hours" step="0.01" min="0" placeholder="Hours" style="width:84px; padding:6px; border-radius:6px; border:1px solid #e6eee9;">
                                            <button type="submit" style="background:#16a34a; color:#fff; border:none; padding:6px 10px; border-radius:6px; cursor:pointer; font-weight:600;">Confirm</button>
                                            <button type="button" class="approve-cancel" data-id="{{ $appeal->id }}" style="background:#e5e7eb; border:none; padding:6px 8px; border-radius:6px; cursor:pointer;">Cancel</button>
                                        </div>
                                    </form>


                                    <form method="POST" action="{{ route('company.attendance-appeals.reject', $appeal->id) }}" class="reject-form" id="reject-form-{{ $appeal->id }}" style="display:none; margin-top:10px;">
                                        @csrf
                                        <div style="display:flex; gap:6px; flex-direction:column; align-items:center;">
                                            <textarea name="reject_reason" rows="2" placeholder="Rejection reason (required)" style="width:200px; padding:6px; border-radius:6px; border:1px solid #f3d0d0;"></textarea>
                                            <div style="display:flex; gap:6px;">
                                                <button type="submit" style="background:#ef4444; color:#fff; border:none; padding:6px 10px; border-radius:6px; cursor:pointer; font-weight:600;">Reject</button>
                                                <button type="button" class="reject-cancel" data-id="{{ $appeal->id }}" style="background:#e5e7eb; border:none; padding:6px 8px; border-radius:6px; cursor:pointer;">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:28px; text-align:center; color:#6b7280;">
                                    No pending appeals found.
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
