{{-- resources/views/coach/lessons/edit.blade.php --}}
@extends('layouts.coach')
@php($sidebarActive = 'dashboard')

@section('title', 'Edit Lesson')

@section('coach-content')
    <div class="mx-auto" style="max-width: 720px;">
        <h1 class="h3 mb-4">Edit Lesson: {{ $lesson->title }}</h1>

        <form method="POST" action="{{ route('coach.lessons.update', $lesson) }}" class="border rounded p-4 shadow mb-4">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ old('title', $lesson->title) }}" class="form-control" required>
                @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description', $lesson->description) }}</textarea>
                @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Scheduled At</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', $lesson->scheduled_at?->format('Y-m-d\\TH:i')) }}" class="form-control">
                @error('scheduled_at')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('coach.lessons.show', $lesson) }}">Cancel</a>
            </div>
        </form>

        <form method="POST" action="{{ route('coach.lessons.destroy', $lesson) }}" onsubmit="return confirm('Delete this lesson?');" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Lesson</button>
        </form>
    </div>
@endsection

