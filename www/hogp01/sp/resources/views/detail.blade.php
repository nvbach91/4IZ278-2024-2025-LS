@extends('app')

@section('title', 'Detail')
@section('content')

<div class="product-detail">
  <div class="product">
    <div class="images">
      @foreach($product->properties['images'] as $image)
      <img src="{{ asset('storage/' . $image) }}">
      @endforeach
    </div>
    <div class="info">
      <h2>{{ $product->name }}</h2>
      <h3>{{ $product->description }}</h3>
      <p>Velkosť: {{ $product->properties['size'] }}</p>
      <p>Farba: {{ $product->properties['color'] }}</p>
      <h2>{{ $product->price }} Kč</h2>
      <form class="form" action="{{ route('cart.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" value="1">
        <button type="submit">Do košíku</button>
      </form>
    </div>
  </div>
</div>

@endsection