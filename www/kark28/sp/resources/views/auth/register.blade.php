@extends('layouts.app')

@section('title', 'Registrace | Rezervační systém')

@section('content')
    <h2>Registrace</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name">Jméno a Příjmení</label>
            <input type="text" class="form-control" name="name @error('name') is-invalid @enderror" required placeholder="Jméno Příjmení" value="{{ old('name') }}">
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email">E-mail</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" required placeholder="email@email.cz" value="{{ old('email') }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password">Heslo</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="********" value="{{ old('password') }}">
            <div id="passwordHelpBlock" class="form-text">
        Heslo musí mít alespoň 8 znaků.
        </div>

        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        </div>
        <div class="mb-3">
            <label for="password_confirmation">Potvrzení hesla</label>
            <input type="password" class="form-control" name="password_confirmation" required placeholder="********">
        </div>
        <button type="submit" class="btn btn-primary">Registrovat se</button>
    </form>
@endsection
