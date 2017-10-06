<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato|Roboto" rel="stylesheet">
  <style type="text/css">
    .logo {
      width: 200px;
    }

    .logo img {
      height: 150px;
    }

    .invoice-table thead {
      background-color: #002538;
      color: #FFF;
    }

    .invoice-table .item-name span {
      display: block;
      font-size: .9em;
    }

    .table .no-line {
      border-top: none !important;
    }

    .table .total {
      background-color: #002538;
      color: #FFF;
      font-size: 1.2em;
    }
  </style>
</head>
<body>
    <div class="container-fluid">
      <div class="header clearfix" style="padding: 10px 0px;">
        <div class="pull-left">
          @if($invoice->org->logo_url)
          <div class="logo"><img class="img-responsive" src="{{ $invoice->org->logo_url }}"></div>
          @endif
        </div>
        <div class="pull-right">
          <h4>{{ $invoice->org->name }}</h4>
          <p style="margin: 0;">
            {{ $invoice->org->address_line_1 }}<br>
            {{ $invoice->org->address_line_2 }}<br>
            {{ $invoice->org->city_town }}<br>
            {{ $invoice->org->state_region }}<br>
            {{ $invoice->org->country }}
          </p>
        </div>
      </div>

      <hr>

      <div class="header sub-header clearfix">
        <div class="pull-left">
          <h4>INVOICE TO:</h4>
          <h3>{{ $invoice->contact->name }}</h3>
          <p> {{ $invoice->contact->address_line_1 }}</p>
          <p> {{ $invoice->contact->address_line_2 }}</p>
          <p> {{ $invoice->contact->address_city_town }}</p>
        </div>
        <div class="pull-right">
          <h2>INVOICE #{{ $invoice->invoice_no }}</h2>
          <p>Ref: {{ $invoice->reference }}</p>
          <p>Date: {{ date("d M, Y", $invoice->raised_at->getTimestamp()) }}</p>
          <p>Due Date: {{ date("d M, Y", $invoice->due_at->getTimestamp()) }}</p>
        </div>
      </div>

      <div class="content" style="padding: 40px 0px;">
        @if($invoice->line_amount_type == 'exclusive')
        <p>Amounts are <strong>Tax Exclusive</strong></p>
        @endif

         @if($invoice->line_amount_type == 'inclusive')
        <p>Amounts are <strong>Tax Exclusive</strong></p>
        @endif

        <table class="table invoice-table">
          <thead>
            <tr>
              <th style="width: 60%;">Item</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              <th>Discount Rate</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($invoice->items as $item)
            <tr class="invoice-row">
              <td class="item-name">
                <p>{{ $item->item->name }}</p>
                <span>{{ $item->description }}</span>
              </td>
              <td class="item-quantity">
                 <p>{{ $item->quantity }}</p>
              </td>
               <td class="item-price">
                <p>{{ $item->unit_price }}</p>
              </td>
              <td class="item-discount">
                <p>{{ $item->discount_rate }}</p>
              </td>
              <td class="item-amount">
                <p>{{ $item->amount }}</p>
              </td>
            </tr>
          @endforeach
            <tr>
              <td colspan="3" class="no-line"></td>
              <td class="totals">Sub Total</td>
              <td class="value">{{ $invoice->sub_total }}</td>
            </tr>
            <tr>
              <td colspan="3" class="no-line"></td>
              <td class="totals">Tax</td>
              <td class="value">{{ $invoice->tax_total }}</td>
            </tr>
            <tr>
              <td colspan="3" class="no-line"></td>
              <td class="totals total">Total Due</td>
              <td class="value total">{{ $invoice->total }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <hr>

      <div></div>
    </div>
</body>
</html>