<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Faktura č. {{ $order->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
    </style>
</head>
<body>

    <h2>Faktura č. {{ $order->id }}</h2>
    <p>Datum vystavení: {{ $order->created_at->format('d.m.Y') }}</p>

    <hr>

    <h3>Fakturační údaje</h3>
    <p>
        Jméno: {{ $order->user->firstname }} {{ $order->user->lastname }}<br>
        E-mail: {{ $order->user->email }}<br>
        Telefon: {{ $order->user->phone }}<br>
        Adresa: {{ $order->billing_address ?? $order->shipping_address }}
    </p>

    <h3>Dodací údaje</h3>
    <p>
        Adresa: {{ $order->shipping_address }}
    </p>

    <hr>

    <h3>Položky objednávky</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Název produktu</th>
                <th>Množství</th>
                <th>Jednotková cena</th>
                <th>Celkem</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->product->price, 2, ',', ' ') }} Kč</td>
                    <td>{{ number_format($item->product->price * $item->quantity, 2, ',', ' ') }} Kč</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <h3>Souhrn</h3>
    <p>
        Cena bez DPH: {{ number_format($total / 1.21, 2, ',', ' ') }} Kč<br>
        DPH (21 %): {{ number_format($total - ($total / 1.21), 2, ',', ' ') }} Kč<br>
        <strong>Cena celkem s DPH: {{ number_format($total, 2, ',', ' ') }} Kč</strong>
    </p>

    <hr>

    <p>Děkujeme za Vaši objednávku!</p>

</body>
</html>
