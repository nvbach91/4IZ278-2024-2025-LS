{{-- resources/views/coach/courses/create.blade.php --}}
@extends('layouts.coach')
@php($sidebarActive = 'dashboard')

@section('title', 'Create New Course')

@section('coach-content')
    <div class="mx-auto" style="max-width: 800px;">
        <h1 class="h3 mb-4">Create Course</h1>

        <form action="{{ route('coach.courses.store') }}" method="POST" class="border rounded p-4 shadow mb-4">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="name">Course Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                @error('name')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control">
                    @error('start_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-control">
                    @error('end_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Create course</button>
        </form>
    </div>
@endsection
