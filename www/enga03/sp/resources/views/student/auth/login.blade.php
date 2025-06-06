@extends('layouts.app')

@section('title', 'Student Login')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
   <form method="POST" action="{{ secure_url('student/login') }}" class="border rounded p-4 shadow w-100" style="max-width: 400px;">
        @csrf
        <h2 class="h4 text-center mb-3">Student login</h2>

       <label for="email">Email</label>
        <div class="mb-3">
            <input name="email" type="email" placeholder="E-mail" class="form-control" required autofocus>
        </div>
       <label for="password">Password</label>
        <div class="mb-3">
            <input name="password" type="password" placeholder="Password" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <button class="btn btn-primary w-100">Log in</button>

       <a href="{{ route('student.login.google') }}" class="btn btn-danger">
           Login with Google
       </a>


       <p class="text-center mt-3 small">
            Coach? <a href="{{ route('coach.login.show') }}">Login here</a>
        </p>
   </form>
</div>
@endsection
