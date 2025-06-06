@extends('layouts.coach')
@php($sidebarActive = 'dashboard')

@section('title', 'Lesson Details')

@section('coach-content')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">{{ $lesson->title }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong></p>
            <p>{{ $lesson->description ?? 'No description provided.' }}</p>
            <p>
                <strong>Scheduled At:</strong><br>
                {{ $lesson->scheduled_at ? $lesson->scheduled_at->format('F j, Y, g:i a') : 'Not scheduled' }}
            </p>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('coach.lessons.edit', $lesson) }}" class="btn btn-warning">Edit Lesson</a>
            <a href="{{ route('coach.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection
