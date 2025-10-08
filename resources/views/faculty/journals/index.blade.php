@extends('layouts.faculty')

@section('content')
<style>
    body {
        background-color: #f8fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.5;
    }

    .container {
        max-width: 1200px;
        margin: 1rem auto;
        padding: 2.5rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        color: #1e293b;
    }

    h2 {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.75rem;
        color: #0f172a;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #10b981;
    }

    .filter-form {
        display: flex;
        gap: 1.25rem;
        margin-bottom: 2rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-form > div {
        flex: 1;
        min-width: 160px;
    }

    .filter-form label {
        display: block;
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .filter-form input[type="text"],
    .filter-form input[type="date"] {
        width: 100%;
        padding: 0.625rem 0.75rem;
        font-size: 0.875rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #f8fafc;
        color: #1e293b;
        transition: all 0.2s ease;
    }

    .filter-form input[type="text"]:focus,
    .filter-form input[type="date"]:focus {
        outline: none;
        border-color: #86efac;
        box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.1);
    }

    .filter-form button {
        padding: 0.625rem 1.25rem;
        background-color: #10b981;
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        height: fit-content;
    }

    .filter-form button:hover {
        background-color: #059669;
    }

    .alert {
        padding: 0.875rem 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .journal-entries {
        margin-top: 1.5rem;
    }

    .journal-entry {
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        border-radius: 10px;
        background-color: white;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .journal-entry:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .journal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .journal-meta {
        flex: 1;
        min-width: 250px;
    }

    .student-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 0.25rem;
    }

    .journal-info {
        font-size: 0.8125rem;
        color: #64748b;
        line-height: 1.6;
    }

    .journal-info strong {
        color: #475569;
    }

    .status-badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-ontime {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-late {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .journal-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-view {
        padding: 0.5rem 1rem;
        background-color: #10b981;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.8125rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-view:hover {
        background-color: #059669;
    }

    .penalty-form {
        display: flex;
        gap: 0.375rem;
        align-items: center;
    }

    .penalty-form input[type="number"] {
        width: 60px;
        padding: 0.375rem 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.8125rem;
        color: #1e293b;
    }

    .penalty-form input[type="number"]:focus {
        outline: none;
        border-color: #fca5a5;
    }

    .btn-deduct {
        padding: 0.5rem 0.875rem;
        background-color: #ef4444;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.8125rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-deduct:hover {
        background-color: #dc2626;
    }

    .journal-content {
        font-size: 0.9375rem;
        line-height: 1.6;
        color: #334155;
        white-space: pre-line;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f1f5f9;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.7);
    }

    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 2rem;
        border: none;
        width: 90%;
        max-width: 800px;
        border-radius: 12px;
        color: #1e293b;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .modal-header h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    .close {
        color: #94a3b8;
        font-size: 2rem;
        font-weight: 300;
        cursor: pointer;
        transition: color 0.2s ease;
        line-height: 1;
    }

    .close:hover {
        color: #1e293b;
    }

    .modal-body {
        font-size: 0.9375rem;
        line-height: 1.6;
    }

    .modal-body p {
        margin-bottom: 1rem;
        color: #475569;
    }

    .modal-body strong {
        color: #1e293b;
        font-weight: 600;
    }

    .modal-body hr {
        border: none;
        border-top: 1px solid #e2e8f0;
        margin: 1.5rem 0;
    }

    .attachment-preview {
        margin-top: 1rem;
    }

    .attachment-preview h4 {
        font-size: 1rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 0.75rem;
    }

    .attachment-preview img {
        max-width: 200px;
        margin-right: 10px;
        margin-top: 10px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .pdf-link {
        display: inline-block;
        margin-top: 10px;
        margin-right: 10px;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .pdf-link:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
    }

    .no-attachments {
        color: #94a3b8;
        font-style: italic;
        font-size: 0.875rem;
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

    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
            margin: 1rem;
        }

        .filter-form {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .filter-form > div {
            min-width: 100%;
        }

        .journal-entry {
            padding: 1.25rem;
        }

        .journal-header {
            flex-direction: column;
        }

        .journal-actions {
            width: 100%;
        }

        .modal-content {
            width: 95%;
            padding: 1.5rem;
        }
    }
</style>

<div class="container">
    <h2>Journal Submissions</h2>

    <form method="GET" action="{{ route('faculty.journals.index') }}" class="filter-form">
        <div>
            <label for="search">Search Student:</label>
            <input type="text" name="search" id="search" placeholder="Enter student name..." value="{{ request('search') }}">
        </div>

        <div>
            <label for="date">Filter by Date:</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}">
        </div>

        <button type="submit">Filter</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="journal-entries">
        @if ($journals->count())
            @foreach ($journals as $journal)
                <div class="journal-entry">
                    <div class="journal-header">
                        <div class="journal-meta">
                            <div class="student-name">{{ $journal->student->name }}</div>
                            <div class="journal-info">
                                <strong>Email:</strong> {{ $journal->student->email }}<br>
                                <strong>Company:</strong> {{ $journal->student->company->name ?? 'N/A' }}<br>
                                <strong>Location:</strong> {{ $journal->student->company->address ?? 'N/A' }}<br>
                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($journal->journal_date)->format('F j, Y') }}
                                at {{ $journal->created_at->format('g:i A') }}
                            </div>
                            <div style="margin-top: 0.5rem;">
                                @if($journal->status == 'Late')
                                    <span class="status-badge status-late">Late</span>
                                @else
                                    <span class="status-badge status-ontime">On Time</span>
                                @endif
                            </div>
                        </div>

                        <div class="journal-actions">
                            <button class="btn-view" onclick="openModal({{ $journal->id }})">View Details</button>

                            @if($journal->status == 'Late')
                                <form action="{{ route('faculty.journals.penalty', $journal->id) }}" method="POST" class="penalty-form">
                                    @csrf
                                    <input type="number" name="penalty_hours" min="0.1" step="0.1" max="1" placeholder="0.5" title="Penalty hours (0.1 - 1.0)">
                                    <button type="submit" class="btn-deduct">Deduct</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="journal-content">{{ Str::limit($journal->content, 200) }}</div>
                </div>
            @endforeach

            <div class="pagination-wrapper">
                {{ $journals->withQueryString()->links('vendor.pagination.prev-next-only') }}
            </div>
        @else
            <p class="no-attachments" style="text-align: center; padding: 2rem;">No journal submissions found.</p>
        @endif
    </div>
</div>

@foreach ($journals as $journal)
    <div id="modal-{{ $journal->id }}" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{ $journal->student->name }}'s Journal</h3>
                <span class="close" onclick="closeModal({{ $journal->id }})">&times;</span>
            </div>
            <div class="modal-body">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($journal->journal_date)->format('F j, Y') }}</p>
                <p><strong>Time Submitted:</strong> {{ $journal->created_at->format('g:i A') }}</p>
                <p><strong>Status:</strong>
                    @if($journal->status == 'Late')
                        <span class="status-badge status-late">Late</span>
                    @else
                        <span class="status-badge status-ontime">On Time</span>
                    @endif
                </p>
                <hr>
                <p><strong>Content:</strong></p>
                <p style="white-space: pre-line;">{{ $journal->content }}</p>

                @if ($journal->attachments->count())
                    <div class="attachment-preview">
                        <h4>Attachments:</h4>
                        @foreach ($journal->attachments as $attachment)
                            @if (in_array($attachment->file_type, ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="Attachment">
                            @else
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="pdf-link">
                                    📄 Download {{ strtoupper($attachment->file_type) }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="no-attachments">No attachments.</p>
                @endif
            </div>
        </div>
    </div>
@endforeach

<script>
    function openModal(id) {
        document.getElementById('modal-' + id).style.display = 'block';
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>
@endsection
