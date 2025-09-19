@extends('layouts.company')

@section('content')
<div class="settings-container">
    <div class="settings-header">
        <h1><i class="far fa-clock"></i> Time In/Out Settings</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="settings-card">
        <h2>Default Time Rules</h2>
        <form method="POST" action="{{ route('company.settings.time_rules.store') }}" class="time-settings-form">
            @csrf

            <div class="form-group">
                <div class="time-range-group">
                    <label>Time In Window</label>
                    <div class="time-inputs">
                        <input type="time" name="default[time_in_start]" value="{{ $company->allowed_time_in_start }}" required>
                        <span class="time-separator">to</span>
                        <input type="time" name="default[time_in_end]" value="{{ $company->allowed_time_in_end }}" required>
                    </div>
                </div>

                <div class="time-range-group">
                    <label>Time Out Window</label>
                    <div class="time-inputs">
                        <input type="time" name="default[time_out_start]" value="{{ $company->allowed_time_out_start }}" required>
                        <span class="time-separator">to</span>
                        <input type="time" name="default[time_out_end]" value="{{ $company->allowed_time_out_end }}" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Save Default Settings
            </button>
        </form>
    </div>

    <div class="settings-card">
        <h2>Override Specific Day</h2>
        <form method="POST" action="{{ route('company.settings.time_rules.store') }}" class="time-settings-form">
            @csrf

            <div class="form-group">
                <div class="form-row">
                    <label>Override Date</label>
                    <input type="date" name="override[date]" required>
                </div>

                <div class="time-range-group">
                    <label>Time In Window (optional)</label>
                    <div class="time-inputs">
                        <input type="time" name="override[time_in_start]">
                        <span class="time-separator">to</span>
                        <input type="time" name="override[time_in_end]">
                    </div>
                </div>

                <div class="time-range-group">
                    <label>Time Out Window (optional)</label>
                    <div class="time-inputs">
                        <input type="time" name="override[time_out_start]">
                        <span class="time-separator">to</span>
                        <input type="time" name="override[time_out_end]">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Save Override
            </button>
        </form>
    </div>

    <div class="settings-card">
        <div class="table-header">
            <h2>Override History</h2>
        </div>

        <div class="table-responsive">
            <table class="overrides-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>In Start</th>
                        <th>In End</th>
                        <th>Out Start</th>
                        <th>Out End</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($overrides as $override)
                    <tr>
                        <td>{{ $override->date }}</td>
                        <td>{{ $override->time_in_start ?? '-' }}</td>
                        <td>{{ $override->time_in_end ?? '-' }}</td>
                        <td>{{ $override->time_out_start ?? '-' }}</td>
                        <td>{{ $override->time_out_end ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="no-data">No overrides set.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>

    .settings-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', sans-serif;
        color: #333;
    }


    .settings-header {
        margin-bottom: 30px;
    }

    .settings-header h1 {
        color: #2c7d4f;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #e8f5e9;
        color: #2c7d4f;
        padding: 12px 15px;
        border-radius: 6px;
        border-left: 4px solid #2c7d4f;
    }


    .settings-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 25px;
        margin-bottom: 25px;
    }

    .settings-card h2 {
        color: #2c7d4f;
        font-size: 1.3rem;
        margin-bottom: 20px;
        font-weight: 600;
    }


    .time-settings-form {
        margin-top: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-row {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .time-range-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    label {
        font-weight: 500;
        color: #2c7d4f;
        font-size: 0.9rem;
    }

    .time-inputs {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .time-separator {
        color: #666;
        font-size: 0.9rem;
    }

    input[type="time"],
    input[type="date"] {
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: border 0.2s;
    }

    input[type="time"]:focus,
    input[type="date"]:focus {
        outline: none;
        border-color: #2c7d4f;
        box-shadow: 0 0 0 2px rgba(44, 125, 79, 0.1);
    }


    .btn-primary {
        background-color: #2c7d4f;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background-color: #236641;
    }


    .table-header {
        margin-bottom: 15px;
    }

    .overrides-table {
        width: 100%;
        border-collapse: collapse;
    }

    .overrides-table th {
        background-color: #f5f9f7;
        color: #2c7d4f;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .overrides-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        color: #555;
    }

    .overrides-table tr:last-child td {
        border-bottom: none;
    }

    .overrides-table tr:hover td {
        background-color: #f9f9f9;
    }

    .no-data {
        text-align: center;
        color: #888;
        font-style: italic;
    }


    @media (max-width: 768px) {
        .time-inputs {
            flex-wrap: wrap;
        }

        .time-separator {
            display: none;
        }
    }
</style>

<script>
    const overrideData = @json($overrides->keyBy('date'));

    const dateInput = document.querySelector('input[name="override[date]"]');
    const inStart = document.querySelector('input[name="override[time_in_start]"]');
    const inEnd = document.querySelector('input[name="override[time_in_end]"]');
    const outStart = document.querySelector('input[name="override[time_out_start]"]');
    const outEnd = document.querySelector('input[name="override[time_out_end]"]');

    dateInput.addEventListener('change', function() {
        const selected = this.value;
        const data = overrideData[selected];

        if (data) {
            inStart.value = data.time_in_start ?? '';
            inEnd.value = data.time_in_end ?? '';
            outStart.value = data.time_out_start ?? '';
            outEnd.value = data.time_out_end ?? '';
        } else {
            inStart.value = '';
            inEnd.value = '';
            outStart.value = '';
            outEnd.value = '';
        }
    });
</script>
@endsection
