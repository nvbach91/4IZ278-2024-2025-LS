@extends('app')

@section('title', 'Checkout')
@section('content')

<div class="checkout">
  <form class="form" method="POST" action="{{ route('checkout') }}">
    @csrf
    <div class="shipping">
      <h3>Dodací údaje a platba</h3>
      <div class="field">
        <label for="shipping_address">Adresa doručení</label>
        <input id="shipping_address" name="shipping_address" value="{{ old('shipping_address', $shippingAddress) }}"  type="text" required>
      </div>
      <div class="field">
        <label for="payment_type">Platební metoda</label>
        <select name="payment_type" id="payment_type">
          <option value="paypal">Paypal</option>
          <option value="cash">Dobírka</option>
          <option value="google_pay">Google Pay</option>
        </select>
      </div>
    </div>
    <div class="details">
      <div class="summary">
        <h3>Shrnutí objednávky</h3>
        <ul>
          @foreach ($cartItems as $item)
          <li>
            <p>Produkt: {{ $item->product->name }}</p>
            <p>Cena: {{ $item->product->price }} Kč</p>
            <p>Počet: {{ $item->quantity }}</p>
          </li>
          @endforeach
        </ul>
        <h4>Cena bez DPH: {{ round($total / 1.21) }} Kč</h4>
        <h4>Cena s DPH: {{ $total }} Kč</h4>
        
      </div>
      
      <button type="submit">Objednat</button>
      @if($errors->any())
      @foreach ($errors->all() as $error)
      <p>{{ $error }}</p>
      @endforeach
      @endif
    </div>
  </div>
</form>
</div>

@endsection