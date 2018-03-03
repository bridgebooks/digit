<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $org->name }} Balance Sheet</title>
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
        <h3 class="txt-center">As at {{ $balance_date }}</h3>
    </div>

    <div class="container">
        <h3>Assets</h3>
        <table class="table">
            <tbody style="font-size: 0.8em;">
                @foreach($assets as $account)
                <tr>
                    <td style="width: 50%;">{{ $account['name'] }}</td>
                    <td style="width: 50%;">NGN {{ number_format($account['balance'], 2) }}</td>
                </tr>
                @endforeach
                <tr class="total">
                    <td style="width: 50%;">Total Assets</td>
                    <td style="width: 50%;">NGN {{ number_format($assets_total, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <h3>Liabilities</h3>
        <table class="table" style="font-size: 0.8em;">
            <tbody>
                @foreach($liabilities as $account)
                <tr>
                    <td style="width: 50%;">{{ $account['name'] }}</td>
                    <td style="width: 50%;">NGN {{ number_format($account['balance'], 2) }}</td>
                </tr>
                @endforeach
                <tr class="total">
                    <td style="width: 50%;">Total Libalities</td>
                    <td style="width: 50%;">NGN {{ number_format($liabilities_total, 2) }}</td>
                </tr>
                <tr class="total">
                    <td style="width: 50%;">Net Assets</td>
                    <td style="width: 50%;">NGN {{ number_format(($assets_total - $liabilities_total), 2) }}</td>
                </tr>
            </tbody>
        </table>

        <h3>Equity</h3>
        <table class="table" style="font-size: 0.8em;">
            <tbody>
                @foreach($equity as $account)
                <tr>
                    <td style="width: 50%;">{{ $account['name'] }}</td>
                    <td style="width: 50%;">NGN {{ number_format($account['balance'], 2) }}</td>
                </tr>
                @endforeach
                <tr class="total">
                    <td style="width: 50%;">Total Equity</td>
                    <td style="width: 50%;">NGN {{ number_format($equity_total, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>