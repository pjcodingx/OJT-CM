<!DOCTYPE html>
<html>
<head>
    <title>Attendance Logs</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { width: 80px; height: auto; }
        .header h1 { margin: 0; font-size: 20px; }
        .header h3, .header p { margin: 0; font-size: 12px; }
        .date { text-align: right; margin-bottom: 10px; font-size: 12px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; }
        th { background-color: #064e17; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/welcome/cmlogo.png') }}" alt="Logo">
        <h1>The College of Maasin</h1>
        <h3>"Nisi Dominus Frustra"</h3>
        <p>Tunga Tunga, Maasin City</p>
        <h2 style="margin-top:3px;">Attendance Logs</h2>
    </div>

    <div class="date">
        Date: {{ \Carbon\Carbon::now()->format('F d, Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Faculty Adviser</th>
                <th>Company</th>
                <th>Address</th>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Accumulated Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $a)
                <tr>
                    <td>{{ $a->student->name }}</td>
                    <td>{{ $a->student->email }}</td>
                    <td>{{ $a->student->course->name ?? '-' }}</td>
                    <td>{{ $a->student->faculty->name ?? '-' }}</td>
                    <td>{{ $a->student->company->name ?? '-' }}</td>
                    <td>{{ $a->student->company->address ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->date)->format('F d, Y') }}</td>
                    <td>{{ $a->time_in ? \Carbon\Carbon::parse($a->time_in)->format('h:i A') : '-' }}</td>
                    <td>{{ $a->time_out ? \Carbon\Carbon::parse($a->time_out)->format('h:i A') : '-' }}</td>
                    <td>{{ round($a->student->accumulated_hours, 1) }} hrs</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
