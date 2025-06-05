@extends('layouts.student')
@php($sidebarActive = 'courses')

@section('title', $course->name)

@section('student-content')
<div class="container my-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h2 class="h5 mb-0">{{ $course->name }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong></p>
            <p>{{ $course->description ?? 'No description provided.' }}</p>
        </div>
        @if($course->lessons && $course->lessons->count())
        <div class="card-footer">
            <h5>Lessons</h5>
            <ul class="list-group">
                @foreach($course->lessons as $lesson)
                <li class="list-group-item">
                    <a href="{{ route('student.lessons.show', $lesson) }}">
                        {{ $lesson->title }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card-footer text-end">
            @if($isEnrolled)
                <form action="{{ route('student.courses.unenroll', $course) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Unenroll</button>
                </form>
            @elseif($course->start_date->isFuture())
                <form action="{{ route('student.courses.enroll', $course) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">Enroll</button>
                </form>
            @endif
            <a href="{{ route('student.open') }}" class="btn btn-secondary">Back to Courses</a>
        </div>
    </div>
</div>
@endsection
