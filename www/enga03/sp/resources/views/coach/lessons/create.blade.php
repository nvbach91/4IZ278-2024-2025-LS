{{-- resources/views/coach/lessons/create.blade.php --}}
@extends('layouts.coach')
@php($sidebarActive = 'dashboard')

@section('title', 'Create Lesson')

@section('coach-content')
    <div class="mx-auto" style="max-width: 720px;">
        <h1 class="h3 mb-4">Create Lesson for {{ $course->name }}</h1>

        <form method="POST" action="{{ route('coach.lessons.store', $course) }}" class="border rounded p-4 shadow mb-4">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Scheduled At</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" class="form-control">
                @error('scheduled_at')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="submit" class="btn btn-primary">Create Lesson</button>
                <a href="{{ route('coach.courses.manage', $course) }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
