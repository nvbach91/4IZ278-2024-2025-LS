{{-- resources/views/coach/open-courses.blade.php --}}
@extends('layouts.coach')
@php($sidebarActive = 'open')

@section('title', 'Open Courses (Coach)')

@section('coach-content')
    <h1 class="h3 mb-4">Open courses (Coach view)</h1>

    @forelse($courses ?? [] as $course)
        <div class="card mb-3">
            <div class="card-body">
                <h2 class="card-title">{{ $course->name }}</h2>
                <p class="text-sm leading-relaxed">{{ Str::limit($course->description, 200) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        lessons: {{ $course->lessons_count ?? 'n/a' }}
                    </span>
                    <form method="POST" action="#"> {{-- sem později přijde akce --}}
                        @csrf
                        <button class="btn btn-sm btn-primary">
                            Manage
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Žádné otevřené kurzy pro kouče.</p>
    @endforelse
@endsection
