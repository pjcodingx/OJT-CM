@extends('layouts.student')

@section('content')
<style>
    body {
        background-color: #f8fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.5;
    }

    .container {
        max-width: 900px;
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

    .journal-date {
        color: #64748b;
        font-size: 0.8125rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
        letter-spacing: 0.02em;
    }

    .journal-content {
        font-size: 0.9375rem;
        line-height: 1.6;
        color: #334155;
        white-space: pre-line;
    }

    .attachments {
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: 1px dashed #e2e8f0;
    }

    .attachments strong {
        font-size: 0.8125rem;
        color: #64748b;
        font-weight: 500;
    }

    .attachments ul {
        padding-left: 1.25rem;
        margin: 0.5rem 0 0 0;
        list-style-type: none;
    }

    .attachments li {
        margin-bottom: 0.25rem;
    }

    .attachments a {
        color: #3b82f6;
        text-decoration: none;
        font-size: 0.8125rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        transition: color 0.2s ease;
    }

    .attachments a:hover {
        color: #2563eb;
        text-decoration: underline;
    }

    .no-entries {
        color: #64748b;
        font-style: italic;
        margin-top: 1.5rem;
        text-align: center;
        padding: 1.5rem;
        background-color: #f8fafc;
        border-radius: 8px;
        border: 1px dashed #e2e8f0;
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
    }

   .download-btn {
    margin-top: 1rem;
    text-align: right;
}

.download-word-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: linear-gradient(135deg, #eb3c25, #d8421d);
    color: white !important;
    font-size: 0.85rem;
    font-weight: 500;
    border-radius: 8px;
    text-decoration: none;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    transition: all 0.2s ease-in-out;
}

.download-word-btn i {
    font-size: 1rem;
}

.download-word-btn:hover {
    background: linear-gradient(135deg, #af1e1e, #d8391d);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.25);
}


</style>

<div class="container">
    <h2>My Journal Logs</h2>

    <form method="GET" class="filter-form">
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">
        </div>

        <div>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">
        </div>

        <button type="submit">Filter</button>
    </form>

    <div class="journal-entries">
        @if ($journals->count())
            @foreach ($journals as $journal)
                <div class="journal-entry">
                    <div class="journal-date">{{ \Carbon\Carbon::parse($journal->journal_date)->format('F d, Y') }}</div>
                    <div class="journal-content">{{ $journal->content }}</div>

                    @if ($journal->attachments->count())
                        <div class="attachments">
                            <strong>Attachments:</strong>
                            <ul>
                                @foreach ($journal->attachments as $file)
                                    <li>
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                            {{ basename($file->file_path) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                   <div class="download-btn">
                        <a href="{{ route('journals.download', $journal->id) }}" class="download-word-btn">
                            <i class="fa-solid fa-file-pdf"></i> Download PDF
                        </a>
                    </div>

                </div>



            @endforeach

            <div class="pagination-wrapper">
                {{ $journals->withQueryString()->links('vendor.pagination.prev-next-only') }}
            </div>
        @else
            <p class="no-entries">No journal entries found for the selected date range.</p>
        @endif
    </div>
</div>
@endsection
