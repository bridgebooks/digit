<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $org->name }} {{ $title }}</title>
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
        <table class="table">
            <thead>
                <tr>
                    <th class="left">Contact</th>
                    <th class="left">Current</th>
                    <th class="left">1 - 30 Days</th>
                    <th class="left">31 - 60 Days</th>
                    <th class="left">61 to 90 Days</th>
                    <th class="left">Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($contacts as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['current'], 2) }}</td>
                    <td>{{ number_format($item['thirty_day'], 2) }}</td>
                    <td>{{ number_format($item['sixty_day'], 2) }}</td>
                    <td>{{ number_format($item['ninety_day'], 2) }}</td>
                    <td>{{ number_format($item['total'], 2) }}</td>
                </tr>
            @endforeach
                <tr class="total">
                    <td>Total</td>
                    <td>{{ number_format($current_total, 2) }}</td>
                    <td>{{ number_format($thirty_day_total, 2) }}</td>
                    <td>{{ number_format($sixty_day_total, 2) }}</td>
                    <td>{{ number_format($ninety_day_total, 2) }}</td>
                    <td>{{ number_format($total, 2) }}</td>
                </tr>
                <tr class="total">
                    <td></td>
                    <td>{{ number_format($current_ratio, 2) }}%</td>
                    <td>{{ number_format($thirty_day_ratio, 2) }}%</td>
                    <td>{{ number_format($sixty_day_ratio, 2) }}%</td>
                    <td>{{ number_format($ninety_day_ratio, 2) }}%</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>