<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jmeno Eshopu</title>
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">

</head>
<body>
  <x-navbar></x-navbar>

  <main class="main-content">
    <h1>New arrivals</h1>
    <div class="product-gallery">
      <div class="product-card"><img src="{{ asset('images/landing/landing1.png') }}"/></div>
      <div class="product-card"><img src="{{ asset('images/landing/landing4.png') }}"/></div>
      <div class="product-card"><img src="{{ asset('images/landing/landing2.png') }}"/></div>
    </div>
    <a href="{{ url('products') }}" class="shop-button">Shop now</a>
  </main>

  <x-footer></x-footer>

</body>
</html>
