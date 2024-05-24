<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Payroll</title>
    <style>
        table {
            font-family: serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .column1 {
            float: left;
            width: 50%;
        }

        .column2 {
            float: left;
            width: 50%;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ public_path('images/header.png') }}" style="width: 40%; ">
    </div>
    <h2>PAYROLL REPORT</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Hired</th>
                <th>Week Period</th>
                <th>Week</th>
                <th>Name</th>
                <th>Job</th>
                <th>Rate</th>
                <th>Days</th>
                <th>Late</th>
                <th>Salary</th>
                <th>Rate/Hour</th>
                <th>Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payroll as $data)
                <tr>
                    <td>{{ $data->pay_id }}</td>
                    <td>{{ $data->userName }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->week_id }}</td>
                    <td>{{ $data->week }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->job }}</td>
                    <td>{{ $data->rate }}</td>
                    <td>{{ $data->days }}</td>
                    <td>{{ $data->late }}</td>
                    <td>{{ $data->salary }}</td>
                    <td>{{ $data->rph }}</td>
                    <td>{{ $data->hrs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <th>No.</th>
                <th>OT Pay</th>
                <th>Holiday</th>
                <th>PhilHealth</th>
                <th>SSS</th>
                <th>Cash Advance</th>
                <th>Gross</th>
                <th>Deduction</th>
                <th>Net</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payroll as $data)
                <tr>
                    <td>{{ $data->pay_id }}</td>
                    <td>{{ $data->otpay }}</td>
                    <td>{{ $data->holiday }}</td>
                    <td>{{ $data->philhealth }}</td>
                    <td>{{ $data->sss }}</td>
                    <td>{{ $data->advance }}</td>
                    <td>{{ $data->gross }}</td>
                    <td>{{ $data->deduction }}</td>
                    <td>{{ $data->net }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table style="margin-top: 10px;">
        <thead>
            <tr>
                <th>TOTAL:</th>
                <th>Salary</th>
                <th>Rate/Hour</th>
                <th>Hours</th>
                <th>OT Pay</th>
                <th>Holiday</th>
                <th>PhilHealth</th>
                <th>SSS</th>
                <th>Advance</th>
                <th>Gross</th>
                <th>Deduction</th>
                <th>Net</th>
            </tr>
        </thead>
        <tbody>
            @if ($total)
                <tr>
                    <td></td>
                    <td>{{ $total->salary }}</td>
                    <td>{{ $total->rph }}</td>
                    <td>{{ $total->hrs }}</td>
                    <td>{{ $total->otpay }}</td>
                    <td>{{ $total->holiday }}</td>
                    <td>{{ $total->philhealth }}</td>
                    <td>{{ $total->sss }}</td>
                    <td>{{ $total->advance }}</td>
                    <td>{{ $total->gross }}</td>
                    <td>{{ $total->deduction }}</td>
                    <td>{{ $total->net }}</td>

                </tr>
            @endif
        </tbody>
    </table>

    <div class="clearfix" style="margin-top: 20px;">
        <div class="column1">
            <h2>Prepared By:</h2>
            <h3>_________________________</h3>
        </div>
        <div class="column2">
            <h2>Checked By:</h2>
            <h3>_________________________</h3>
        </div>
    </div>
</body>

</html>
