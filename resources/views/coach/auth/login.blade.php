@extends('layouts.app')

@section('title', 'Coach Login')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
   <form method="POST" action="{{ route('coach.login') }}" class="border rounded p-4 shadow w-100" style="max-width: 400px;">
        @csrf
        <h2 class="h4 text-center mb-3">Coach login</h2>

        <div class="mb-3">
            <input name="email" type="email" placeholder="E-mail" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <input name="password" type="password" placeholder="Password" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="remember" class="form-check-input" id="rememberCoach">
            <label class="form-check-label" for="rememberCoach">Remember me</label>
        </div>

        <button class="btn btn-primary w-100">Log in</button>

        <p class="text-center mt-3 small">
            Student? <a href="{{ route('student.login.show') }}">Login here</a>
        </p>
   </form>
</div>
@endsection
