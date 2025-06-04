@extends('layouts.student')
@php($sidebarActive = 'profile')

@section('title', 'Profile Settings')

@section('student-content')
    <h1 class="h3 mb-4">Profile Settings</h1>

    {{-- FLASH bannery už máš v layouts.app (success / error) --}}

    <form method="POST" action="{{ route('student.profile.update') }}" class="mb-4" style="max-width: 600px;">
        @csrf
        @method('PUT')

        {{-- Profile picture preview --}}
        <div class="text-center mb-3">
            <img src="{{ $student->profile_picture }}" alt="Profile picture" class="rounded-circle" width="128" height="128">
        </div>

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" type="text" value="{{ old('name', $student->name) }}" class="form-control" required>
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input name="email" type="email" value="{{ old('email', $student->email) }}" class="form-control" required>
            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Birth year --}}
        <div class="mb-3">
            <label class="form-label">Birth year</label>
            <input name="birth_year" type="number" min="1900" max="{{ date('Y') }}" value="{{ old('birth_year', $student->birth_year) }}" class="form-control" required>
            @error('birth_year') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        {{-- Profile picture URL --}}
        <div class="mb-3">
            <label class="form-label">Profile picture URL</label>
            <input name="profile_picture" type="url" value="{{ old('profile_picture', $student->profile_picture) }}" class="form-control">
            @error('profile_picture') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="accordion mb-3" id="pwdAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPwd">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePwd" aria-expanded="false" aria-controls="collapsePwd">
                        Change password
                    </button>
                </h2>
                <div id="collapsePwd" class="accordion-collapse collapse" aria-labelledby="headingPwd" data-bs-parent="#pwdAccordion">
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
    
    @if (Route::has('student.profile.destroy'))
        <form method="POST" action="{{ route('student.profile.destroy') }}" class="mt-8">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete your account?');">Delete account</button>
        </form>
    @endif
@endsection
