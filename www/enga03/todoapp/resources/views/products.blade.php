<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>
    <h1>Products</h1>
    <ul id="product-list">
        @foreach ($items as $item)
        <li>
            {{ $item['name'] }} : {{ $item['price'] }}
        </li>
        
        @endforeach
    </ul>
</body>
</html></head>