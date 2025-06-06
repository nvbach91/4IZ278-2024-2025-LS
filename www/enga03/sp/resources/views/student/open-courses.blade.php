@extends('layouts.student')
@php($sidebarActive = 'open')

@section('title', 'Open Courses')

@section('student-content')
    <h1 class="h3 mb-4">Open courses</h1>

    <div class="row">
        @forelse($courses as $course)
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <p class="card-text">{{ $course->description }}</p>
                        <a href="{{ route('student.courses.show', $course) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Momentálně nejsou žádné otevřené kurzy.</p>
        @endforelse
    </div>
    {{ $courses->links() }}
@endsection
