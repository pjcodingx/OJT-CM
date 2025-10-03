@extends('layouts.student')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .form-container h2 {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: 600;
        display: block;
        margin-bottom: 8px;
        color: #004d40;
    }

    input[type="text"], input[type="date"], textarea, input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #063d19;
        border-radius: 6px;
        font-size: 14px;
    }

    button {
        padding: 10px 20px;
        background-color: #004d40;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
    }

    .success-message {
        background: #d9fdd3;
        color: #256029;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
    }

     .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        padding: 10px;
        border-radius: 6px;
        margin-top: 10px;
        font-size: 14px;
    }
</style>



@if(session('error'))
    <div style="background: #b71c1c; color: white; padding: 10px; margin-bottom: 10px; border-radius: 4px;">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div style="background: #ff6f00; color: white; padding: 10px; margin-bottom: 10px; border-radius: 4px;">
        <ul style="margin:0; padding-left:20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="form-container">
    <h2 style="color: #004d40;">Submit Daily Journal</h2>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <form action="{{ route('student.journals.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="journal_date">Journal Date</label>
            <input type="date" name="journal_date" id="journal_date" value="{{ old('journal_date') }}" required>
            @error('journal_date') <small style="color: red;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="content">Journal Content <span id="wordCount">0 words</span></label>
            <textarea name="content" id="content" rows="5" required>{{ old('content') }}</textarea>
            @error('content') <small style="color: red;">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="attachments">Attachments (PDF, JPG, PNG – multiple allowed)</label>
            <input type="file" name="attachments[]" id="attachments" multiple>
            @error('attachments.*') <small style="color: red;">{{ $message }}</small> @enderror
        </div>



        <button type="submit">Submit Journal</button>
    </form>
</div>

<script>
const textarea = document.getElementById('content');
const wordCountLabel = document.getElementById('wordCount');

textarea.addEventListener('input', () => {
    const words = textarea.value.trim().split(/\s+/).filter(w => w.length > 0);
    wordCountLabel.textContent = words.length + ' words';
});
</script>
@endsection
