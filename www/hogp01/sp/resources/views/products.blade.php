@extends('app')

@section('title', 'Produkty')
@section('content')

<div class="products">
  <div class="banner">
    @php
    $heading = 'Produkty';
    
    if (isset($gender) && isset($category)) {
      $heading = $category;
    } elseif (isset($gender)) {
      $heading = ucfirst($gender);
    }
    @endphp
    <h1>{{ $heading }}</h1>
  </div>
  <div class="wrapper">
    <div class="filter">
      <div class="categories">
        <h3>Kategorie</h3>
        <a href="/products/Muži"><h4>Muži</h4></a>
        <ul>
          <li><a href="/products/muži/Trička">Trička</a></li>
          <li><a href="/products/muži/Košile">Košile</a></li>
          <li><a href="/products/muži/Kalhoty">Kalhoty</a></li>
          <li><a href="/products/muži/Bundy">Bundy</a></li>
          <li><a href="/products/muži/Boty">Boty</a></li>
          <li><a href="/products/muži/Mikiny">Mikiny</a></li>
          <li><a href="/products/muži/Svetry">Svetry</a></li>
          <li><a href="/products/muži/Doplňky">Doplňky</a></li>
        </ul>
        
        <a href="/products/Ženy"><h4>Ženy</h4></a>
        <ul>
          <li><a href="/products/ženy/Trička">Trička</a></li>
          <li><a href="/products/ženy/Košile">Košile</a></li>
          <li><a href="/products/ženy/Kalhoty">Kalhoty</a></li>
          <li><a href="/products/ženy/Bundy">Bundy</a></li>
          <li><a href="/products/ženy/Boty">Boty</a></li>
          <li><a href="/products/ženy/Mikiny">Mikiny</a></li>
          <li><a href="/products/ženy/Svetry">Svetry</a></li>
          <li><a href="/products/ženy/Doplňky">Doplňky</a></li>
          <li><a href="/products/ženy/Šaty">Šaty</a></li>
          <li><a href="/products/ženy/Sukně">Sukně</a></li>
        </ul>
        
      </div>
      <div class="properties">
        <div>
          <h3>Barva:</h3>
          <button onclick="filterProducts('color', '')"><i class="bi bi-ban"></i></button>
          <button onclick="filterProducts('color', 'red')">🔴</button>
          <button onclick="filterProducts('color', 'blue')">🔵</button>
          <button onclick="filterProducts('color', 'green')">🟢</button>
          <button onclick="filterProducts('color', 'yellow')">🟡</button>
          <button onclick="filterProducts('color', 'black')">⚫</button>
          <button onclick="filterProducts('color', 'white')">⚪</button>
          <button onclick="filterProducts('color', 'purple')">🟣</button>
          <button onclick="filterProducts('color', 'orange')">🟠</button>
        </div>
        
        <div>
          <h3>Velikost:</h3>
          <button onclick="filterProducts('size', '')"><i class="bi bi-ban"></i></button>
          <button onclick="filterProducts('size', 'XS')">XS</button>
          <button onclick="filterProducts('size', 'S')">S</button>
          <button onclick="filterProducts('size', 'M')">M</button>
          <button onclick="filterProducts('size', 'L')">L</button>
          <button onclick="filterProducts('size', 'XL')">XL</button>
          <button onclick="filterProducts('size', 'XXL')">XXL</button>
        </div>
      </div>
    </div>
    <div class="cards">
      @foreach($products as $product)
      <a href="{{ route('detail',$product->id) }}" class="card" data-color="{{ $product->properties['color'] }}" data-size="{{ $product->properties['size'] }}">
        <img src="{{ asset('storage/' . $product->properties['thumbnail']) }}" alt="">
        <p class="nametag">{{ $product->name }}</p>
        <div class="properties">
          <p>{{ $product->price }} Kč</p>
          <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit"><i class="bi bi-bag-plus"></i></button>
          </form>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</div>

@endsection