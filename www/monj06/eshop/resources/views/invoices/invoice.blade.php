<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
</head>

<body>
    <h1>Invoice</h1>
    <p>Order ID: {{ $order->id }}</p>
    <p>Total: {{ $order->price }} Kč</p>
    <p>Address: {{ $order->street }}, {{ $order->postal_code }} {{ $order->city }}</p>
    <p>Payment: {{ $order->payment }}</p>
</body>

</html>
