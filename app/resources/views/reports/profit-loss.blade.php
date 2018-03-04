<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $org->name }} Profit Loss</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
    <style type="text/css">
        .txt-center {
            text-align: center;
        }
        hr {
            border-top-width: 3px;
            border-top-color: #3b6ea0;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Balance Sheet</h2>
    <hr>
</div>

<div class="container">
    <h2 class="txt-center">{{ $org->name }}</h2>
    <p class="txt-center">Reporting period: {{ $start_date }} to {{ $end_date }}</p>
</div>

<div class="container">
    <p>Income</p>
    <table class="table">
        <tbody style="font-size: 0.8em;">
        @foreach($income as $account)
            <tr>
                <td style="width: 50%;">{{ $account['name'] }}</td>
                <td style="width: 50%;">NGN {{ number_format($account['balance'], 2) }}</td>
            </tr>
        @endforeach
        <tr class="total">
            <td style="width: 50%;">Total Income</td>
            <td style="width: 50%;">NGN {{ number_format($income_total, 2) }}</td>
        </tr>
        </tbody>
    </table>

    <p>Less Cost of Sales</p>
    <table class="table" style="font-size: 0.8em;">
        <tbody>
        @foreach($purchases as $account)
            <tr>
                <td style="width: 50%;">{{ $account['name'] }}</td>
                <td style="width: 50%;">NGN {{ number_format($account['balance'], 2) }}</td>
            </tr>
        @endforeach
        <tr class="total">
            <td style="width: 50%;">Total Cost of Sales</td>
            <td style="width: 50%;">NGN {{ number_format($purchase_total, 2) }}</td>
        </tr>
        <tr class="total">
            <td style="width: 50%;">Gross Profit </td>
            <td style="width: 50%;">NGN {{ number_format(($gross_profit), 2) }}</td>
        </tr>
        </tbody>
    </table>

    <p>Less Operating Expenses</p>
    <table class="table" style="font-size: 0.8em;">
        <tbody>
        @foreach($expenses as $account)
            <tr>
                <td style="width: 50%;">{{ $account['name'] }}</td>
                <td style="width: 50%;">NGN {{ number_format($account['balance'], 2) }}</td>
            </tr>
        @endforeach
        <tr class="total">
            <td style="width: 50%;">Total Operating Expenses</td>
            <td style="width: 50%;">NGN {{ number_format($expense_total, 2) }}</td>
        </tr>
        <tr class="total">
            <td style="width: 50%;">Net Profit/td>
            <td style="width: 50%;">NGN {{ number_format($net_profit, 2) }}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>