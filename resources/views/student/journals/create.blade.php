@extends('layouts.student')

@section('content')
<style>
    body {
        background-color: #f8fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .form-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .form-container h2 {
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
        font-weight: 600;
        text-align: center;
        color: #0f172a;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #10b981;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        font-weight: 600;
        display: block;
        margin-bottom: 0.5rem;
        color: #1e293b;
        font-size: 0.875rem;
    }

    .label-info {
        font-weight: 400;
        color: #64748b;
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }

    input[type="date"],
    textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9375rem;
        background-color: #f8fafc;
        color: #1e293b;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    input[type="date"]:focus,
    textarea:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        background-color: #fff;
    }

    textarea {
        min-height: 250px;
        resize: vertical;
        line-height: 1.6;
    }

    #wordCount {
        float: right;
        font-weight: 400;
        color: #64748b;
        font-size: 0.75rem;
    }

    button[type="submit"] {
        width: 100%;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.2s ease;
        margin-top: 1rem;
    }

    button[type="submit"]:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .success-message {
        background: #d1fae5;
        color: #065f46;
        padding: 0.875rem 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 500;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        padding: 0.875rem 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-weight: 500;
        border: 1px solid #fecaca;
    }

    .alert-warning {
        background-color: #fef3c7;
        color: #92400e;
        padding: 0.875rem 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-weight: 500;
        border: 1px solid #fde68a;
    }

    .alert-warning ul {
        margin: 0;
        padding-left: 1.25rem;
    }

    .file-upload-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .file-upload-wrapper input[type="file"] {
        position: absolute;
        left: -9999px;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background-color: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #64748b;
        font-size: 0.875rem;
    }

    .file-upload-label:hover {
        border-color: #10b981;
        background-color: #f0fdf4;
        color: #059669;
    }

    .file-list {
        margin-top: 0.75rem;
        font-size: 0.8125rem;
        color: #475569;
    }

    .file-item {
        padding: 0.5rem 0.75rem;
        background-color: #f1f5f9;
        border-radius: 6px;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    @media (max-width: 768px) {
        .form-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .form-container h2 {
            font-size: 1.5rem;
        }
    }


.alert {
    position: fixed;
    top: 90px;
    right: 30px;
    padding: 14px 22px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 14px;
    color: #fff;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    animation: slideIn 0.5s ease, fadeOut 0.5s ease 4s forwards;
}

/* Success (your green tone) */
.success-alert {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

/* Info (blue) */
.info-alert {
    background: #eff6ff;
    color: #1e3a8a;
    border: 1px solid #bfdbfe;
}

/* Error (red) */
.error-alert {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

@keyframes slideIn {
    from {
        transform: translateX(120%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateX(120%);
    }
}

</style>

@if (session('success'))
    <div class="alert success-alert">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert error-alert" style="max-width: 800px; margin: 1rem auto;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-container">
    <h2>Submit Daily Journal</h2>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student.journals.store') }}" method="POST" enctype="multipart/form-data" id="journalForm">
        @csrf

        <div class="form-group">
            <label for="journal_date">Journal Date</label>
            <input type="date" name="journal_date" id="journal_date" value="{{ old('journal_date') }}" required>
        </div>

        <div class="form-group">
            <label for="content">
                Journal Content
                <span id="wordCount" class="label-info">0 words</span>
            </label>
            <textarea name="content" id="content" placeholder="Start writing your journal entry here..." required>{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label for="attachments">
                Attachments
                <span class="label-info">(PDF, JPG, PNG – multiple allowed)</span>
            </label>
            <div class="file-upload-wrapper">
                <input type="file" name="attachments[]" id="attachments" multiple accept=".pdf,.jpg,.jpeg,.png" onchange="displayFiles()">
                <label for="attachments" class="file-upload-label">
                    📎 Click to select files or drag and drop
                </label>
            </div>
            <div id="fileList" class="file-list"></div>
        </div>

        <button type="submit">Submit Journal</button>
    </form>
</div>

<script>
// Word count functionality
const textarea = document.getElementById('content');
const wordCountLabel = document.getElementById('wordCount');

textarea.addEventListener('input', () => {
    const text = textarea.value.trim();
    const words = text.split(/\s+/).filter(w => w.length > 0);
    wordCountLabel.textContent = words.length + ' words';
});

// File upload display
function displayFiles() {
    const input = document.getElementById('attachments');
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';

    if (input.files.length > 0) {
        Array.from(input.files).forEach((file) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            fileItem.innerHTML = `
                <span>📄 ${file.name} (${(file.size / 1024).toFixed(2)} KB)</span>
            `;
            fileList.appendChild(fileItem);
        });
    }
}
</script>
@endsection
