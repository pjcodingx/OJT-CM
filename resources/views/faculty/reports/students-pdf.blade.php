<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OJT Summary Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            height: auto;
        }
        .header h1, .header h2, .header h3, .header p {
            margin: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #064e17;
        }
        th {
            background-color: #064e17;
            color: white;
            padding: 5px;
            text-align: center;
        }
        td {
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('images/welcome/cmlogo.png') }}" alt="Logo">
    <h1>The College of Maasin</h1>
    <h3><em>"Nisi Dominus Frustra"</em></h3>
    <p>R. Kangleon St. Tunga Tunga, Maasin City</p>
     <h2 style="color: #02360f">Summary of Report in OJT</h2>
    <p style="margin-top: 10px;">{{ \Carbon\Carbon::now()->format('F d, Y') }}</p>

</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Company</th>
            <th>Address</th>
            <th>Total Journals</th>
            <th>Rating</th>
            <th>Appeals submitted</th>
            <th>Absences</th>
            <th>Total Hours</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->company->name ?? '--' }}</td>
            <td>{{ $student->company->address ?? '--' }}</td>
            <td>{{ $student->total_journals }}</td>
            <td>{{ number_format($student->average_rating ?? 0, 0) . '/' . '5' }}</td>
            <td>{{ $student->appealsCount() }}</td>
            <td>{{ $student->calculateAbsences() }}</td>
            <td>{{ $student->accumulated_hours }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
