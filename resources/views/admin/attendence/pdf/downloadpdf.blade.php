<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF</title>
    <style>
        .get_Customer_details {
            border-collapse: collapse;
            width: 100%;
        }

        .get_Customer_details th,
        .get_Customer_details td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .get_Customer_details th {
            background-color: #f2f2f2;
        }

        .logo {
            width: 100px; /* Adjust width as needed */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="card">
            <div class="card p-3">
                <div  align="center">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/xpertidea_logo.png'))) }}" alt="Logo" class="logo">

            </div>
            <div class="row s-filter">
                <div class="col-md-6 d-flex align-items-center">
                    <b class="ml-2 mb-0" id="links">Name: {{ $employeeName ?? '' }}</b>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <b class="mr-2 mb-0" id="links">Date: {{ $date ?? '' }} to {{ $enddate ?? '' }}</b>
                </div>
            </div>
            
            <hr>
            <table class="table get_Customer_details">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time out</th>
                        <th>Remark</th>
                        <th>Total Hours</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody id="attendance-data">
                    @foreach($attendance_records_pdf as $item)
                    <tr>
                        <td>{{ $item->employeeName  }}</td>
                        <td>{{ $item->date  }}</td>
                        <td>{{ $item->time_in  }}</td>
                        <td>{{ $item->time_out  }}</td>
                        <td>{{ $item->remark  }}</td>
                        <td>{{ $item->total_hours  }}</td>
                        <td>{{ $item->status  }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>