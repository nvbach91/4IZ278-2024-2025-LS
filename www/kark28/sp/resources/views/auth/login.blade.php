@extends('layouts.app')

@section('title', 'Přihlášení | Rezervační systém')

@section('content')
    <h2>Přihlášení</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email">E-mail</label>
            <input type="email" name="email" required autofocus class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password">Heslo</label>
            <input type="password" name="password" required class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Přihlásit se</button>
    </form>
    <br>
    <p>Nemáte účet? <a href="{{ route('register') }}">Registrujte se zde!</a></p>
@endsection
