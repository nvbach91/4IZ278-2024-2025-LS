@extends('app')

@section('title', 'Login')
@section('content')
<div class="auth-box">
  <div class="wrapper">
    <form class="form" method="POST" action="/login">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" value="{{ old('email') }}" type="email">
      </div>
      <div class="field">
        <label for="password">Heslo</label>
        <input id="password" name="password" type="password">
      </div>
      @if ($errors->any())
      <div class="error">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
      </div>
      @endif
      <button type="submit">Prihlasit se</button>
      <a href="/register">Registrace</a>
    </form>
  </div>
</div>
@endsection
