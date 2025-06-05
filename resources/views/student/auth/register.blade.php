@extends('layouts.app')

@section('title', 'Student Register')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
   <form method="POST" action="{{ route('student.register') }}" class="border rounded p-4 shadow w-100" style="max-width: 400px;">
        @csrf

        <h2 class="h4 text-center mb-3">Student sign-up</h2>

        {{-- Name --}}
        <div class="mb-3">
            <input name="name" type="text" placeholder="Full name" class="form-control" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <input name="email" type="email" placeholder="E-mail" class="form-control" required>
        </div>

        <div class="mb-3">
            <input name="birth_year" type="number" min="1900" max="{{ date('Y') }}" class="form-control" value="{{ old('birth_year') }}" required>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <input name="password" type="password" placeholder="Password" class="form-control" required>
        </div>

        {{-- Confirm password --}}
        <div class="mb-3">
            <input name="password_confirmation" type="password" placeholder="Confirm password" class="form-control" required>
        </div>


        <button class="btn btn-primary w-100">Sign up</button>

       <a href="{{ route('student.login.google') }}" class="btn btn-danger">
           Login with Google
       </a>

       <p class="text-center mt-3 small">
            Already have an account?
            <a href="{{ route('student.login.show') }}">Log in</a>
        </p>
   </form>
</div>
@endsection
