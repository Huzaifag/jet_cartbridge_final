<!DOCTYPE html>
<html>

<head>
  <title>Invoice #{{ $order->id }}</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .invoice-box {
      max-width: 600px;
      margin: auto;
      padding: 30px;
      border: 1px solid #eee;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
      font-size: 16px;
      line-height: 24px;
      color: #555;
    }

    .invoice-box table {
      width: 100%;
      line-height: inherit;
      text-align: left;
    }

    .invoice-box table td {
      padding: 5px;
      vertical-align: top;
    }

    .invoice-box table tr.top table td {
      padding-bottom: 20px;
    }

    .invoice-box table tr.information table td {
      padding-bottom: 40px;
    }

    /* Add more styles for items table, totals, etc. */
  </style>
</head>

<body>
  <div class="invoice-box">
    <table>
      <tr class="top">
        <td colspan="2">
          <table>
            <tr>
              <td class="title">
                <img src="https://w7.pngwing.com/pngs/621/196/png-transparent-e-commerce-logo-logo-e-commerce-electronic-business-ecommerce-angle-text-service.png" alt="Company Logo" width="100">
              </td>
              <td>
                Invoice #: {{ $order->id }}<br>
                Created: {{ $order->created_at->format('M d, Y') }}<br>
                Due: {{ $order->created_at->addDays(30)->format('M d, Y') }}
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr class="information">
        <td colspan="2">
          <table>
            <tr>
              <td>
                Your Company Name<br>
                123 Main Street<br>
                Anytown, USA 12345
              </td>
              <td>
                Customer Name<br>
                {{ $order->customer->name }}<br>
                {{ $order->customer->email }}
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
</body>

</html>