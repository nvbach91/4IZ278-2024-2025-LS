@extends('layouts.student')
@php($sidebarActive = 'dashboard')

@section('title', 'My Courses')

@section('student-content')
<div class="container my-4">
    <h1 class="h3 mb-4">My Courses</h1>

    @if($courses->isEmpty())
    <p>You are currently not enrolled in any courses.</p>
    @else
    <div class="row">
        @foreach($courses as $course)
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $course->name }}</h5>
                    <p class="card-text">{{ $course->description }}</p>
                    <a href="{{ route('student.courses.show', $course) }}" class="btn btn-primary">View Course</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $courses->links() }}
    @endif
</div>
@endsection
