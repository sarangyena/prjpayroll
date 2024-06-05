<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Payslip</title>
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
        <img src="{{ public_path('images/header.png') }}" style="width: 60%; ">
    </div>
    <table>
        <tr>
            <th>Date Of Joining</th>
            <td>: {{$payroll->hired}}</td>
            <th>Employee Name</th>
            <td>: {{$payroll->name}}</td>
        </tr>
        <tr>
            <th>Payroll No.</th>
            <td>: {{$payroll->pay_id}}</td>
            <th>Job</th>
            <td>: {{$payroll->job}}</td>
        </tr>
        <tr>
            <th>Week Period</th>
            <td>: {{$payroll->week_id}}</td>
            <th>Pay Period</th>
            <td>: {{$payroll->pay_period}}</td>
        </tr>
    </table>
    <h3>PAYSLIP REPORT</h3>
    <table>
        <tr>
            <th>Earnings</th>
            <th>Hours/Days</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
        <tr>
            <th>Standard Pay</th>
            <td>{{$payroll->days}}</td>
            <td>{{$payroll->rate}}</td>
            <td>{{$payroll->salary}}</td>
        </tr>
        <tr>
            <th>Overtime Pay</th>
            <td>{{$payroll->hrs}}</td>
            <td>{{$payroll->rph}}</td>
            <td>{{$payroll->otpay}}</td>
        </tr>
        <tr>
            <th>Holiday Pay</th>
            <td></td>
            <td></td>
            <td>{{$payroll->holiday}}</td>
        </tr>
        <tr>
            <th></th>
            <td></td>
            <th>Gross Pay</th>
            <td>{{$payroll->gross}}</td>
        </tr>
    </table>
    <table style="margin-top: 10px;">
        <tr>
            <th>Deductions</th>
            <th>Amount</th>
        </tr>
        <tr>
            <th>PhilHealth</th>
            <td>{{$payroll->philhealth}}</td>
        </tr>
        <tr>
            <th>SSS</th>
            <td>{{$payroll->sss}}</td>
        </tr>
        <tr>
            <th>Cash Advance</th>
            <td>{{$payroll->advance}}</td>
        </tr>
        <tr>
            <th>Subtotal</th>
            <td>{{$payroll->deduction}}</td>
        </tr>
    </table>
    <table style="margin-top: 10px;">
        <tr>
            <th>Net Pay</th>
            <td>{{$payroll->net}}</td>
        </tr>
    </table>

    <h2>{{$convert}}</h2>
    <div class="clearfix" style="margin-top: 20px;">
        <div class="column1">
            <h3>Employer Signature</h3>
            <p>_________________________</p>
        </div>
        <div class="column2">
            <h3>Employee Signature</h3>
            <p>_________________________</p>
            <h3>{{$payroll->name}}</h3>
        </div>
    </div>


</body>

</html>
