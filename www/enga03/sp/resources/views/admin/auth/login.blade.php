@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <form method="POST" action="{{ route('admin.login') }}" class="border rounded p-4 shadow w-100" style="max-width: 400px;">
        @csrf
        <h2 class="h4 text-center mb-3">Admin login</h2>
        <label for="email">Email</label>
        <div class="mb-3">
            <input name="email" type="email" class="form-control" required autofocus>
        </div>
        <label for="password">Password</label>
        <div class="mb-3">
            <input name="password" type="password" class="form-control" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="remember" class="form-check-input" id="rememberAdmin">
            <label class="form-check-label" for="rememberAdmin">Remember me</label>
        </div>
        <button class="btn btn-primary w-100">Log in</button>
    </form>
</div>
@endsection
