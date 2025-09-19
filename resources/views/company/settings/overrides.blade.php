@extends('layouts.company')

@section('content')
<h2 style="color:darkgreen;">Override Time Settings for Specific Days</h2>

@if(session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

<form action="{{ route('company.settings.overrides.save') }}" method="POST" style="margin-top: 20px;">
    @csrf
    <label>Date:</label>
    <input type="date" name="date" required>

    <label>Time In Start:</label>
    <input type="time" name="time_in_start" required>

    <label>Time In End:</label>
    <input type="time" name="time_in_end" required>

    <label>Time Out Start:</label>
    <input type="time" name="time_out_start" required>

    <label>Time Out End:</label>
    <input type="time" name="time_out_end" required>

    <button type="submit" style="margin-top: 10px;">Save Override</button>
</form>

<hr style="margin: 30px 0;">

<h3>Existing Overrides</h3>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time In (Start - End)</th>
            <th>Time Out (Start - End)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($overrides as $override)
        <tr>
            <td>{{ $override->date }}</td>
            <td>{{ $override->time_in_start }} - {{ $override->time_in_end }}</td>
            <td>{{ $override->time_out_start }} - {{ $override->time_out_end }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
