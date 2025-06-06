{{-- resources/views/coach/courses/edit.blade.php --}}
@extends('layouts.coach')

@php($sidebarActive = 'dashboard') {{-- nebo 'courses' pokud máte jinou logiku sidebaru --}}

@section('title', 'Edit Course')

@section('coach-content')
    <div class="mx-auto" style="max-width: 720px;">
        <h1 class="h3 mb-4">Edit Course: {{ $course->name }}</h1>

        <form action="{{ route('coach.courses.update', $course) }}" method="POST" class="border rounded p-4 shadow mb-4">
            @csrf
            @method('PUT')

            {{-- Název kurzu --}}
            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input type="text" name="name" value="{{ old('name', $course->name) }}" class="form-control" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Šablona kurzu (template_id) – zatím necháme prázdné, pokud nechceme používat --}}
            <div class="mb-3">
                <label class="form-label">Template ID (optional)</label>
                <input type="number" name="template_id" value="{{ old('template_id', $course->template_id) }}" class="form-control" required>
                @error('template_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Začátek a konec kurzu --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $course->start_date?->format('Y-m-d')) }}" class="form-control" required>
                    @error('start_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $course->end_date?->format('Y-m-d')) }}" class="form-control" required>
                    @error('end_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Schedule Info --}}
            <div class="mb-3">
                <label class="form-label">Schedule Info (optional)</label>
                <input type="text" name="schedule_info" value="{{ old('schedule_info', $course->schedule_info) }}" placeholder="Např. „Pondělí a středa 15:00–17:00“" class="form-control">
                @error('schedule_info')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('coach.courses.manage', $course) }}">Cancel</a>
            </div>
        </form>

        <form method="POST" action="{{ route('coach.courses.destroy', $course) }}" class="mt-3" onsubmit="return confirm('Delete this course?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Course</button>
        </form>
    </div>
@endsection
