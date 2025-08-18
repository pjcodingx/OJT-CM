<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Students Summary Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { width: 80px; height: auto; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 0; font-size: 12px; }
        .date { text-align: right; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 6px; text-align: center; font-size: 12px; }
        th { background-color: #064e17; color: white; }
    </style>
</head>
<body>

<div class="header">
    <img src="{{ public_path('images/welcome/cmlogo.png') }}" alt="Logo">
    <h1>The College of Maasin</h1>
    <p><em>"Nisi Dominus Frustra"</em></p>
    <p>Tunga Tunga, Maasin City</p>
    <h2>Student Summary Report</h2>
</div>

<div class="date">
    Date: {{ $date }}
</div>

<table>
    <thead>
        <tr>

            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Company</th>
            <th>OJT Adviser</th>
            <th>Total Hours</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>

            <td>{{ $student['Name'] }}</td>
            <td>{{ $student['Email'] }}</td>
            <td>{{ $student['Course'] }}</td>
            <td>{{ $student['Company'] }}</td>
            <td>{{ $student['OJT Adviser'] }}</td>
            <td>{{ $student['Total Hours'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
