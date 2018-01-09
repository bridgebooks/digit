<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payslip</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
    <style type="text/css">
        .header .logo {
            width: 200px;
            padding: 15px 0;
        }

        .header .logo img {
            height: 70px;
        }

        .header h3 {
            margin: 0;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="header">
        @if($slip->payrun->org->logo_url)
            <div class="logo"><img class="img-responsive" src="{{ $slip->payrun->org->logo_url }}"></div>
            <h3>{{ $slip->payrun->org->name }}</h3>
            <hr>
        @else
            <h3>{{ $slip->payrun->org->name }}</h3>
            <hr>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <p><strong>Date: </strong>{{ date("d M, Y", $slip->updated_at->getTimestamp()) }}</p>
            <p><strong>Name: </strong>{{ $slip->employee->first_name.' '.$slip->employee->last_name }}</p>
            <p><strong>Role: </strong>{{ $slip->employee->role ? $slip->employee->role : "N/A" }}</p>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <p><strong>Pay Day</strong></p>
            <p>{{ date("d M, Y", $slip->payrun->payment_date->getTimestamp()) }}</p>

            <p><strong>Pay Period</strong></p>
            <p>{{ date("d M, Y", $slip->payrun->start_date->getTimestamp()) }} - {{ date("d M, Y", $slip->payrun->start_date->getTimestamp()) }}</p>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <h4>Earnings (NGN)</h4>
            <table class="table table-responsive">
                @foreach($wages as $wage)
                    <tr>
                        <td>{{ $wage->item->name }}</td>
                        <td>{{ number_format($wage->amount, 2) }}</td>
                    </tr>
                @endforeach
                @foreach($allowances as $allowance)
                <tr>
                    <td>{{ $allowance->item->name }}</td>
                    <td>{{ number_format($allowance->amount, 2) }}</td>
                </tr>
                @endforeach
                @foreach($reimbursements as $reimbursement)
                <tr>
                    <td>{{ $reimbursement->item->name }}</td>
                    <td>{{ number_format($reimbursement->amount, 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td><strong>Gross Earnings</strong></td>
                    <td><strong>{{ number_format($earnings, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="col-lg-6 col-md-6">
            <h4>Deductions (NGN)</h4>
            <table class="table table-responsive">
                @foreach($deductions as $deduction)
                <tr>
                    <td>{{ $deduction->item->name }}</td>
                    <td>{{ number_format($deduction->amount, 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td>TAX</td>
                    <td>{{ number_format($slip->tax, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Gross Deductions</strong></td>
                    <td><strong>{{ number_format($gross_deductions, 2) }}</strong></td>
                </tr>
            </table>
            <h4>Net Pay: NGN {{ number_format($slip->net_pay, 2) }}</h4>
        </div>
    </div>
    <hr>

    @if($slip->payrun->notes)
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <p>{{ $slip->payrun->notes }}</p>
        </div>
    </div>
    @endif
</div>
</body>
</html>