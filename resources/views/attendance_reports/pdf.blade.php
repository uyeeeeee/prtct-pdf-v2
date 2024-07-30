<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .summary {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="title">Company-wide Attendance Report</div>
    
    <div class="summary">
        <p><strong>Period:</strong> {{ $startDate }} to {{ $endDate }}</p>
        <p><strong>Total Employees:</strong> {{ $totalEmployees }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Present</th>
                <th>Late</th>
                <th>Absent</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $data)
                <tr>
                    <td>{{ $data['name'] }}</td>
                    <td>{{ $data['present'] }}</td>
                    <td>{{ $data['late'] }}</td>
                    
                    <td>{{ $data['missing'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>