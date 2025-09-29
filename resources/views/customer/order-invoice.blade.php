<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add print-friendly CSS */
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .details, .items { width: 100%; margin-bottom: 20px; }
        .items th, .items td { border-bottom: 1px solid #ddd; padding: 8px; }
        .items th { background-color: #f4f4f4; }
        .total { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice #{{ $order->id }}</h1>
        <p>Placed on {{ $order->created_at->format('d M Y') }}</p>
    </div>

    <div class="details">
        <h3>Customer Details</h3>
        <p>Name: {{ $order->customer->name }}</p>
        <p>Email: {{ $order->customer->email }}</p>
        <p>Shipping Address: {{ $order->home_no }}, {{ $order->street }}, {{ $order->city }}</p>
    </div>

    <table class="items" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->product_name }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total: ${{ number_format($order->total_amount, 2) }}</p>

</body>
</html>
