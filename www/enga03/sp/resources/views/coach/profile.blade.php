{{-- resources/views/coach/profile.blade.php --}}
@extends('layouts.coach')
@php($sidebarActive = 'profile')

@section('title', 'Coach Profile')

@section('coach-content')
    <h1 class="h3 mb-4">Profile Settings (Coach)</h1>

    <form method="POST" action="{{ route('coach.profile.update') }}" class="mb-4" style="max-width: 600px;">
        @csrf
        @method('PUT')

        {{-- Profile picture preview --}}
        <div class="text-center mb-3">
            <img src="{{ $coach->profile_picture }}" alt="Profile picture" class="rounded-circle" width="128" height="128">
        </div>

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" type="text" value="{{ old('name', $coach->name ?? '') }}" class="form-control" required>
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input name="email" type="email" value="{{ old('email', $coach->email ?? '') }}" class="form-control" required>
            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Profile picture URL --}}
        <div class="mb-3">
            <label class="form-label">Profile picture URL</label>
            <input name="profile_picture" type="url" value="{{ old('profile_picture', $coach->profile_picture ?? '') }}" class="form-control">
            @error('profile_picture') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Change password --}}
        <div class="accordion mb-3" id="coachPwdAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="coachHeadingPwd">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#coachCollapsePwd" aria-expanded="false" aria-controls="coachCollapsePwd">
                        Change password
                    </button>
                </h2>
                <div id="coachCollapsePwd" class="accordion-collapse collapse" aria-labelledby="coachHeadingPwd" data-bs-parent="#coachPwdAccordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label class="form-label">New password</label>
                            <input name="password" type="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm password</label>
                            <input name="password_confirmation" type="password" class="form-control">
                        </div>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary">Save changes</button>
    </form>
@endsection
