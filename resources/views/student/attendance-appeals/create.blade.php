@extends('layouts.student')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .appeal-form-container {
        max-width: 750px;
        margin: 2rem auto;
        background: white;
        border-radius: 16px;
        padding: 2rem 2.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .form-header {
        margin-bottom: 2rem;
        border-bottom: 3px solid #107936;
        padding-bottom: 1rem;
        color: #107936;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .attendance-info {
        font-size: 0.9rem;
        color: #475569;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 2rem;
    }

    .attendance-info div {
        font-weight: 600;
    }

    form label {
        font-weight: 600;
        color: #374151;
        display: block;
        margin-bottom: 0.5rem;
    }

    textarea, input[type="file"] {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        color: #111827;
        background: #f9fafb;
        transition: border-color 0.3s ease;
    }

    textarea:focus, input[type="file"]:focus {
        outline: none;
        border-color: #107936;
        background: #ecfdf5;
    }

    .error-message {
        color: #dc2626;
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }

    .button-group {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    button[type="submit"] {
        background: linear-gradient(135deg, #107936 0%, #0f6a2f 100%);
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(16, 121, 54, 0.3);
        transition: background 0.3s ease, transform 0.2s ease;
        font-size: 1rem;
    }

    button[type="submit"]:hover {
        background: linear-gradient(135deg, #0f6a2f 0%, #0d5a28 100%);
        transform: translateY(-2px);
    }

    a.cancel-link {
        color: #6b7280;
        font-weight: 600;
        text-decoration: none;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    a.cancel-link:hover {
        color: #107936;
    }

    @media (max-width: 640px) {
        .attendance-info {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<div class="appeal-form-container">
    <div class="form-header">
        Submit Appeal for {{ $attendance->date ?? $attendance->created_at->toDateString() }}
    </div>

    <div class="attendance-info">
        <div><strong>Time In:</strong> {{ $attendance->time_in ?? '—' }}</div>
        <div><strong>Time Out:</strong> {{ $attendance->time_out ?? '—' }}</div>
    </div>

    <form action="{{ route('student.attendance-appeals.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="reason">Reason</label>
            <textarea name="reason" id="reason" rows="5" required>{{ old('reason') }}</textarea>
            @error('reason')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label for="attachment">Attachment (optional)</label>
            <input type="file" name="attachment" id="attachment" accept="image/*" />
            @error('attachment')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="button-group appeal">
            <button type="submit">Submit Appeal</button>
            <a href="{{ route('student.attendance-appeals.index') }}" class="cancel-link">Cancel</a>
        </div>
    </form>
</div>
@endsection
