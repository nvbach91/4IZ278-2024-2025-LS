<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Faktura</title>
</head>

<body>
    <h1>Faktura</h1>
    <p>ID objednávky: {{ $order->id }}</p>
    <p>Cena celkem: {{ $order->price }} Kč</p>
    <p>Adresa: {{ $order->street }}, {{ $order->postal_code }} {{ $order->city }}</p>
    <!--<p>Payment: {{ $order->payment }}</p>-->
</body>

</html>
