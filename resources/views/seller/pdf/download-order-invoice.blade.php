<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order['id'] }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .invoice-container {
            width: 640px; /* Fixed width for A4 PDF */
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header .invoice-details {
            text-align: right;
        }

        .header .invoice-details h1 {
            font-size: 24px;
            margin: 0 0 8px 0;
        }

        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .address-section .address-box {
            width: 48%;
            padding: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .address-section h4 {
            margin-top: 0;
            font-size: 14px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th, .items-table td {
            text-align: left;
            padding: 6px 8px;
            border: 1px solid #ccc;
        }

        .items-table th {
            background-color: #f1f1f1;
        }

        .items-table td.total-column {
            text-align: right;
        }

        .summary-box {
            width: 250px;
            margin-left: auto;
            border: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
        }

        .summary-box .total-row td {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #000;
        }

        /* Print Styles for PDF */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: #fff;
                width: 100%;
            }
            .invoice-container {
                width: 100%;
                max-width: 800px; /* Ensure content fits A4 */
                margin: 0;
                padding: 10px;
                box-shadow: none;
                border: none;
                box-sizing: border-box;
            }
            .header img {
                max-width: 100px; /* Prevent logo from overflowing */
            }
            .items-table, .summary-box {
                page-break-inside: avoid; /* Prevent table splitting */
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <img src="https://w7.pngwing.com/pngs/621/196/png-transparent-e-commerce-logo-logo-e-commerce-electronic-business-ecommerce-angle-text-service.png" alt="Company Logo" width="100">
            <div class="invoice-details">
                <h1>INVOICE</h1>
                <p><strong>Invoice #:</strong> {{ $order['id'] }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($order['created_at'])->format('M d, Y') }}</p>
                <p><strong>Payment Method:</strong> {{ $order['payment_method'] }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order['status']) }}</p>
            </div>
        </div>

        <div class="address-section">
            <div class="address-box">
                <h4>Bill To:</h4>
                <p>
                    <strong>{{ $order['customer']['name'] }}</strong><br>
                    {{ $order['customer']['email'] }}<br>
                    {!! nl2br(e($order['billing_address'])) !!}
                </p>
            </div>
            <div class="address-box">
                <h4>Ship To:</h4>
                <p>
                    <strong>{{ $order['customer']['name'] }}</strong><br>
                    {!! nl2br(e($order['shipping_address'])) !!}
                </p>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th class="total-column">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                <tr>
                    <td>{{ $item['product']['name'] ?? 'Product ' . $item['product_id'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td class="total-column">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-box">
            <table width="100%">
                <tr>
                    <td>Subtotal:</td>
                    <td class="total-column">${{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Shipping:</td>
                    <td class="total-column">${{ number_format($shipping, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax ({{ $tax }}%):</td>
                    <td class="total-column">${{ number_format($subtotal * ($tax / 100), 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Grand Total:</td>
                    <td class="total-column">${{ number_format($total, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>