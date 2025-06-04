@extends('app')

@section('title', 'Objednávka')

@section('content')

<div class="confirmation">
  <h1>Vaše objednávka byla uspěšne vytvořena.</h1>
  <div class="summary">
    <ul>
      <li>Fakturační údaje</li>
      <ul>
        <li>Jmeno:{{ $order->user->firstname}} {{ $order->user->lastname}}</li>
        <li>Email:{{ $order->user->email}}</li>
        <li>Tel.č.:{{ $order->user->phone}}</li>
        <li>Adresa:{{ $order->shipping_address}}</li>
      </ul>
      <li>Dodací údaje</li>
      <ul>
        <li>Adresa:{{ $order->shipping_address}}</li>
      </ul>
      <li>Objednané zboží</li>
      <ul>
        @foreach ($order->items as $item)
        <li>{{ $item->product->name }} {{ $item->quantity }}x {{ $item->product->price }} Kč</li>
        @endforeach
      </ul>
      <li>Cena</li>
      <ul>
        <li>Cena bez DPH: {{ $total / 1.21 }} Kč</li>
        <li>Cena s DPH: {{ $total }} Kč</li>
      </ul>
    </ul>
  </div>
</div>  

@endsection
