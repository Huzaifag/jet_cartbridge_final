<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        /* Basic CSS for the PDF */
        body { font-family: sans-serif; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .item-table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .item-table th, .item-table td { padding: 8px; border: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h1>Invoice #{{ $order->id }}</h1>
        <p>Date: {{ $order->created_at->format('M d, Y') }}</p>

        <p>Customer: {{ $order->customer->name }}</p>

        <h2>Order Items</h2>
        <table class="item-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3>Grand Total: ${{ number_format($order->total, 2) }}</h3>
    </div>
</body>
</html>
