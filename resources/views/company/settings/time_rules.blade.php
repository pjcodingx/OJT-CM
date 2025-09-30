@extends('layouts.company')

@section('content')
<div class="settings-container">
    <div class="settings-header">
        <div class="header-content">
            <div class="header-title">
                <i class="far fa-clock"></i>
                <div>
                    <h1>Time In/Out Settings</h1>
                    <p>Configure default schedules and special date overrides</p>
                </div>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="settings-grid">
        <!-- Default Time Rules Card -->
        <div class="settings-card">
            <div class="card-header">
                <i class="fas fa-calendar-check"></i>
                <h2>Default Time Rules</h2>
            </div>
            <form method="POST" action="{{ route('company.settings.time_rules.store') }}" class="time-settings-form">
                @csrf

                <div class="form-section">
                    <div class="time-range-group">
                        <div class="start-date-group">
                            <label><i class="fas fa-hourglass-start"></i> OJT Start Date:</label>
                            <input type="date" name="default[start_date]" value="{{ $company->default_start_date }}">
                        </div>

                        <label><i class="fas fa-sign-in-alt"></i> Time In Window</label>
                        <div class="time-inputs">
                            <input type="time" name="default[time_in_start]" value="{{ $company->allowed_time_in_start }}" required>
                            <span class="time-separator">to</span>
                            <input type="time" name="default[time_in_end]" value="{{ $company->allowed_time_in_end }}" required>
                        </div>
                    </div>

                    <div class="time-range-group">
                        <label><i class="fas fa-sign-out-alt"></i> Time Out Window</label>
                        <div class="time-inputs">
                            <input type="time" name="default[time_out_start]" value="{{ $company->allowed_time_out_start }}" required>
                            <span class="time-separator">to</span>
                            <input type="time" name="default[time_out_end]" value="{{ $company->allowed_time_out_end }}" required>
                        </div>
                    </div>

                    <div class="working-days-section">
                        <label><i class="fas fa-calendar-week"></i> Default Working Days</label>
                        <div class="working-days">
                            @php
                                $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                                $selectedDays = json_decode($company->working_days ?? '[]');
                            @endphp

                            @foreach($days as $day)
                                <label class="day-checkbox">
                                    <input type="checkbox" name="default[working_days][]" value="{{ $day }}"
                                        {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span class="day-name">{{ substr($day, 0, 3) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save Default Settings
                </button>
            </form>
        </div>

        <!-- Override Specific Day Card -->
        <div class="settings-card">
            <div class="card-header">
                <i class="fas fa-calendar-plus"></i>
                <h2>Override Specific Day</h2>
            </div>
            <form method="POST" action="{{ route('company.settings.time_rules.store') }}" class="time-settings-form">
                @csrf

                <div class="form-section">
                    <div class="date-input-group">
                        <label><i class="fas fa-calendar-day"></i> Override Date</label>
                        <input type="date" name="override[date]" required>
                    </div>

                    <div class="time-range-group">
                        <label><i class="fas fa-sign-in-alt"></i> Time In Window <span class="optional">(optional)</span></label>
                        <div class="time-inputs">
                            <input type="time" name="override[time_in_start]" id="override_time_in_start">
                            <span class="time-separator">to</span>
                            <input type="time" name="override[time_in_end]" id="override_time_in_end">
                        </div>
                    </div>

                    <div class="time-range-group">
                        <label><i class="fas fa-sign-out-alt"></i> Time Out Window <span class="optional">(optional)</span></label>
                        <div class="time-inputs">
                            <input type="time" name="override[time_out_start]" id="override_time_out_start">
                            <span class="time-separator">to</span>
                            <input type="time" name="override[time_out_end]" id="override_time_out_end">
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <label class="no-work-checkbox">
                            <input type="checkbox" name="override[is_no_work]" id="noWorkCheckbox" value="1">
                            <span class="checkmark-square"></span>
                            <span class="checkbox-label">
                                <i class="fas fa-ban"></i> No Work Today
                            </span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus-circle"></i> Add Override
                </button>
            </form>
        </div>
    </div>

    <!-- Override History -->
    <div class="settings-card full-width">
        <div class="card-header">
            <i class="fas fa-history"></i>
            <h2>Override History</h2>
        </div>

        <div class="table-container">
            <table class="overrides-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-calendar"></i> Date</th>
                        <th><i class="fas fa-clock"></i> Time In Start</th>
                        <th><i class="fas fa-clock"></i> Time In End</th>
                        <th><i class="fas fa-clock"></i> Time Out Start</th>
                        <th><i class="fas fa-clock"></i> Time Out End</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($overrides as $override)
                    <tr>
                        <td class="date-cell">
                            <strong>{{ \Carbon\Carbon::parse($override->date)->format('M d, Y') }}</strong>
                            <span class="day-label">{{ \Carbon\Carbon::parse($override->date)->format('l') }}</span>
                        </td>
                        <td>{{ $override->time_in_start ?? '-' }}</td>
                        <td>{{ $override->time_in_end ?? '-' }}</td>
                        <td>{{ $override->time_out_start ?? '-' }}</td>
                        <td>{{ $override->time_out_end ?? '-' }}</td>
                        <td>
                            @if($override->is_no_work)
                                <span class="badge badge-no-work">
                                    <i class="fas fa-ban"></i> No Work
                                </span>
                            @else
                                <span class="badge badge-regular">
                                    <i class="fas fa-briefcase"></i> Working Day
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="no-data">
                            <i class="fas fa-inbox"></i>
                            <p>No overrides set yet</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}



.settings-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
    font-family: 'Inter', 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
    color: #1a3a2e;
    background: linear-gradient(135deg, #f5f9f7 0%, #e8f5e9 100%);
    min-height: 100vh;
}

/* Header */
.settings-header {
    margin-bottom: 2rem;
}

.header-content {
    background: linear-gradient(135deg, #1a4d2e 0%, #2c7d4f 100%);
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(26, 61, 46, 0.15);
}

.header-title {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    color: white;
}

.header-title > i {
    font-size: 3rem;
    opacity: 0.9;
}

.header-title h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.header-title p {
    font-size: 0.95rem;
    opacity: 0.9;
    font-weight: 400;
}

.alert-success {
    background: white;
    color: #2c7d4f;
    padding: 1rem 1.25rem;
    border-radius: 8px;
    border-left: 4px solid #2c7d4f;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 1rem;
    box-shadow: 0 2px 8px rgba(44, 125, 79, 0.1);
    font-weight: 500;
}

.alert-success i {
    font-size: 1.25rem;
}

/* Grid Layout */
.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

/* Cards */
.settings-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
    padding: 0;
    overflow: hidden;
    border: 1px solid rgba(44, 125, 79, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.settings-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12);
}

.settings-card.full-width {
    grid-column: 1 / -1;
}

.card-header {
    background: linear-gradient(135deg, #1a4d2e 0%, #2c7d4f 100%);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: white;
}

.card-header i {
    font-size: 1.5rem;
    opacity: 0.9;
}

.card-header h2 {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

/* Form Styles */
.time-settings-form {
    padding: 2rem;
}

.form-section {
    display: flex;
    flex-direction: column;
    gap: 1.75rem;
}

.time-range-group,
.date-input-group,
.working-days-section {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

label {
    font-weight: 600;
    color: #1a4d2e;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

label i {
    color: #2c7d4f;
    font-size: 0.9rem;
}

.optional {
    font-weight: 400;
    color: #666;
    font-size: 0.85rem;
    font-style: italic;
}

.time-inputs {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.time-separator {
    color: #2c7d4f;
    font-weight: 600;
    font-size: 0.9rem;
}

input[type="time"],
input[type="date"] {
    padding: 0.875rem 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
    font-family: inherit;
    background: #fafafa;
    color: #1a4d2e;
    font-weight: 500;
}

input[type="time"]:focus,
input[type="date"]:focus {
    outline: none;
    border-color: #2c7d4f;
    background: white;
    box-shadow: 0 0 0 4px rgba(44, 125, 79, 0.1);
}

input[type="time"]:disabled,
input[type="date"]:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f5f5f5;
}

/* Working Days */
.working-days {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.day-checkbox {
    position: relative;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0;
    background: #f5f9f7;
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
    transition: all 0.2s;
    font-weight: 500;
}

.day-checkbox:hover {
    border-color: #2c7d4f;
    background: white;
}

.day-checkbox input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.day-checkbox .checkmark {
    display: none;
}

.day-checkbox input[type="checkbox"]:checked ~ .day-name {
    color: white;
}

.day-checkbox input[type="checkbox"]:checked + .checkmark + .day-name {
    color: white;
}

.day-checkbox input[type="checkbox"]:checked {
    background: #2c7d4f;
}

.day-checkbox:has(input[type="checkbox"]:checked) {
    background: linear-gradient(135deg, #1a4d2e 0%, #2c7d4f 100%);
    border-color: #1a4d2e;
}

.day-name {
    color: #1a4d2e;
    font-weight: 600;
    font-size: 0.9rem;
    transition: color 0.2s;
}

/* No Work Checkbox */
.checkbox-group {
    padding: 1rem;
    background: #f5f9f7;
    border-radius: 8px;
    border: 2px dashed #d0e5db;
}

.no-work-checkbox {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-weight: 500;
}

.no-work-checkbox input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkmark-square {
    width: 24px;
    height: 24px;
    border: 2px solid #2c7d4f;
    border-radius: 6px;
    background: white;
    position: relative;
    transition: all 0.2s;
}

.no-work-checkbox:hover .checkmark-square {
    border-color: #1a4d2e;
    background: #f5f9f7;
}

.no-work-checkbox input[type="checkbox"]:checked ~ .checkmark-square {
    background: linear-gradient(135deg, #1a4d2e 0%, #2c7d4f 100%);
    border-color: #1a4d2e;
}

.no-work-checkbox input[type="checkbox"]:checked ~ .checkmark-square::after {
    content: "✓";
    position: absolute;
    color: white;
    font-size: 16px;
    font-weight: bold;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #1a4d2e;
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #1a4d2e 0%, #2c7d4f 100%);
    color: white;
    border: none;
    padding: 0.875rem 1.75rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    transition: all 0.2s;
    margin-top: 0.5rem;
    box-shadow: 0 4px 12px rgba(44, 125, 79, 0.2);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(44, 125, 79, 0.3);
}

.btn-primary:active {
    transform: translateY(0);
}

/* Table */
.table-container {
    padding: 1.5rem;
    overflow-x: auto;
}

.overrides-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.overrides-table thead tr {
    background: linear-gradient(135deg, #f5f9f7 0%, #e8f5e9 100%);
}

.overrides-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.85rem;
    color: #1a4d2e;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #d0e5db;
}

.overrides-table th i {
    margin-right: 0.5rem;
    color: #2c7d4f;
}

.overrides-table td {
    padding: 1.25rem;
    border-bottom: 1px solid #f0f0f0;
    color: #333;
    font-size: 0.95rem;
}

.overrides-table tbody tr {
    transition: background-color 0.2s;
}

.overrides-table tbody tr:hover {
    background-color: #f5f9f7;
}

.date-cell {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.date-cell strong {
    color: #1a4d2e;
    font-weight: 600;
}

.day-label {
    font-size: 0.8rem;
    color: #666;
    font-weight: 400;
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    white-space: nowrap;
}

.badge-no-work {
    background: linear-gradient(135deg, #ef5350 0%, #d32f2f 100%);
    color: white;
}

.badge-regular {
    background: linear-gradient(135deg, #66bb6a 0%, #43a047 100%);
    color: white;
}

.no-data {
    text-align: center;
    padding: 3rem 1rem !important;
    color: #999;
}

.no-data i {
    font-size: 3rem;
    color: #ddd;
    margin-bottom: 1rem;
    display: block;
}

.no-data p {
    margin-top: 0.5rem;
    font-style: italic;
}

/* Responsive */
@media (max-width: 1200px) {
    .settings-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .settings-container {
        padding: 1rem;
    }

    .header-content {
        padding: 1.5rem;
    }

    .header-title {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .header-title h1 {
        font-size: 1.5rem;
    }

    .time-inputs {
        flex-direction: column;
        align-items: stretch;
    }

    .time-separator {
        text-align: center;
    }

    .working-days {
        grid-template-columns: repeat(2, 1fr);
    }

    .table-container {
        padding: 1rem;
    }

    .overrides-table {
        font-size: 0.85rem;
    }

    .overrides-table th,
    .overrides-table td {
        padding: 0.75rem 0.5rem;
    }
}
</style>

<script>
const noWorkCheckbox = document.getElementById('noWorkCheckbox');
const timeInputs = [
    document.getElementById('override_time_in_start'),
    document.getElementById('override_time_in_end'),
    document.getElementById('override_time_out_start'),
    document.getElementById('override_time_out_end')
];

function toggleTimeInputs() {
    const disabled = noWorkCheckbox.checked;
    timeInputs.forEach(input => {
        if (input) {
            input.disabled = disabled;
            if (disabled) {
                input.value = '';
                input.style.opacity = '0.5';
            } else {
                input.style.opacity = '1';
            }
        }
    });
}

if (noWorkCheckbox) {
    noWorkCheckbox.addEventListener('change', toggleTimeInputs);
    toggleTimeInputs();
}
</script>

@endsection
