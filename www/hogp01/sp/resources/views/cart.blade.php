@extends('app')

@section('title', 'Košík')
@section('content')

<div class="cart">
  @if(!$items->isEmpty())
  <div class="cards">
    @foreach($items as $item)
    <div class="card">
      <img src="{{ asset('storage/' .$item->product->properties['thumbnail']) }}" alt="">
      <p class="nametag">{{$item->product->name }}</p>
      <div class="properties">
        <p>{{ $item->product->price }} Kč</p>
        <form action="{{ route('cart.update', $item->id) }}" method="POST">
          @csrf
          <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
          <button type="submit"><i class="bi bi-plus-circle"></i></button>
        </form>
        <p>{{$item->quantity }}</p>
        <form action="{{ route('cart.update', $item->id) }}" method="POST">
          @csrf
          <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
          <button type="submit"><i class="bi bi-dash-circle"></i></button>
        </form>
      </div>
    </div>
    @endforeach
  </div>
  <div class="total">
    <h1>{{ $total }} Kč</h1>
    <a href="{{ route('checkout') }}"><button class="success">Objednať</button></a>
  </div>
  @else
  <h1>Máte prázdný košík</h1>
  @endif
</div>

@endsection