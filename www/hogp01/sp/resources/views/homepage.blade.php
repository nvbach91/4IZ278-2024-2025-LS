@extends('app')

@section('title', 'Landing page')
@section('content')

<main class="main-content">
  <h1>New arrivals</h1>
  <div class="product-gallery">
    <div class="product-card"><img src="{{ asset('images/landing/landing1.png') }}"/></div>
    <div class="product-card"><img src="{{ asset('images/landing/landing4.png') }}"/></div>
    <div class="product-card"><img src="{{ asset('images/landing/landing2.png') }}"/></div>
  </div>
  <a href="{{ url('products') }}" class="shop-button">Shop now</a>
</main>

@endsection