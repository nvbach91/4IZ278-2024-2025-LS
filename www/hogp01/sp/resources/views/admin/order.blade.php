@extends('app')

@section('title', 'Orders')
@section('content')

<!--Error Toast-->
@if ($errors->any())
  <div id="toast-error" class="toast-error">
  @foreach ($errors->all() as $error)
    {{ $error }}
  @endforeach
  </div>
@endif
<script>
    setTimeout(() => {
        const toast = document.getElementById('toast-error');
        if (toast) {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500); // Wait for fade-out transition
        }
    }, 2000);
</script>

<div class="order-editor">
  
  <div class="wrapper">
    <h3>Objednávky</h3>
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
          <form class="form" method="POST" action="{{ route('admin.orders.update', $order->id) }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @method('PUT')
            <div class="field">
              <label for="status">Status</label>
              <select name="status" id="status">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Čeká na platbu</option>
                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Zaplaceno</option>
                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Odesláno</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Dokončeno</option>
              </select>
            </div>
            <button type="submit">Uložiť</button>
          </form>
          <form class="form" method="POST" action="{{ route('admin.orders.destroy', $order->id) }}"  enctype="multipart/form-data" onsubmit="return confirm('Ste si istý že chcete produkt zmazať?');">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @method('DELETE')
            <button class="warning" type="submit">Zmazať</button>
          </form>
        </div>
      </div>
      @endforeach
    </div>
    
  </div>
</div>

@endsection