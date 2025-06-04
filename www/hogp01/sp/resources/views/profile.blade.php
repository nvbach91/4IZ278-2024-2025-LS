@extends('app')

@section('title', 'Profile')
@section('content')

<div class="profile">
  <div class="wrapper">
    <div class="user">
      <form class="form" action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <h3>Osobní údaje a změna hesla</h3>
        <div class="form-hrbox">
          <div class="field">
            <label for="firstname">Jmeno</label>
            <input id="firstname" name="firstname" value="{{ $user->firstname }}"  type="text">
          </div>
          <span class="spacer">&nbsp;</span>
          <div class="field">
            <label for="lastname">Prijmeni</label>
            <input id="lastname" name="lastname" value="{{ $user->lastname }}"  type="text">
          </div>
        </div>
        <div class="field">
          <label for="email">Email</label>
          <input id="email" name="email" value="{{ $user->email }}" type="email">
        </div>
        <div class="field">
          <label for="phone">Telefon</label>
          <input id="phone" name="phone" value="{{ $user->phone }}" type="phone">
        </div>
        <div class="field">
          <label for="password">Heslo</label>
          <input id="password" name="password" type="password">
        </div>
        <div class="field">
          <label for="password_confirmation">Heslo znovu</label>
          <input id="password_confirmation" name="password_confirmation" type="password">
        </div>
        <button type="submit">Uložit</button>
      </form>
    </div>
    <div class="orders">
      <div class="accordion">
        @foreach($orders as $order)
        
        @php
        $total = 0;
        
        foreach ($order->items as $item) {
          $total += $item->quantity * $item->product->price;
        }
        
        @endphp
        <div class="item">
          <div class="header">
            <div class="left">
              <p>Objednávka {{ $order->id }}#</p>
            </div>
            <div class="right">
              <p>{{ $total }} Kč</p>
              <p>{{ $order->created_at }}</p>
              <i class="toggle bi bi-caret-up"></i>
            </div>
          </div>
          <div class="content">
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
                  <li>Cena bez DPH: {{ round($total / 1.21) }} Kč</li>
                  <li>Cena s DPH: {{ $total }} Kč</li>
                </ul>
              </ul>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection