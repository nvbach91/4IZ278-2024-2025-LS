@extends('app')

@section('title', 'Registrace')
@section('content')

<div class="auth-box">
  <div class="wrapper">
    <form class="form" method="POST" action="/register">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-hrbox">
        <div class="field">
          <label for="firstname">Jmeno</label>
          <input id="firstname" name="firstname" value="{{ old('firstname') }}"  type="text">
        </div>
        <span class="spacer">&nbsp;</span>
        <div class="field">
          <label for="lastname">Prijmeni</label>
          <input id="lastname" name="lastname" value="{{ old('lastname') }}"  type="text">
        </div>
      </div>
      <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" value="{{ old('email') }}" type="email">
      </div>
      <div class="field">
        <label for="phone">Telefon</label>
        <input id="phone" name="phone" value="{{ old('phone') }}" type="phone">
      </div>
      <div class="field">
        <label for="password">Heslo</label>
        <input id="password" name="password" type="password">
      </div>
      <div class="field">
        <label for="password_confirmation">Heslo znovu</label>
        <input id="password_confirmation" name="password_confirmation" type="password">
      </div>
      @if ($errors->any())
      <div class="error">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
      </div>
      @endif
      <button type="submit">Zaregistrovat se</button>
      <a href="/login">Prihlasit se</a>
    </form>
  </div>
</div>

@endsection