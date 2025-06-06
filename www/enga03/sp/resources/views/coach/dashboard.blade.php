{{-- resources/views/coach/dashboard.blade.php --}}
@extends('layouts.coach')
@php($sidebarActive = 'dashboard')

@section('title', 'Coach Dashboard')

@section('coach-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Courses you are instructing:</h1>
        <a href="{{ route('coach.courses.create') }}" class="btn btn-primary btn-sm">
            Add course
        </a>
    </div>

    <div class="vstack gap-3">
        @forelse($courses as $course)
            <div class="card">
                <div class="card-body">
                    {{-- Název + datum další lekce (pokud máš v modelu Course atribut next_session) --}}
                    <div class="d-flex justify-content-between">
                        <h2 class="card-title">{{ $course->name }}</h2>
                        <p class="text-muted small">
                            @if(isset($course->next_session))
                                next session: {{ $course->next_session->format('j.n.Y') }}
                            @else
                                next session: TBA
                            @endif
                        </p>
                    </div>

                    {{-- Krátký popis --}}
                    <p class="mb-2">
                        {{ Str::limit($course->description, 200) }}
                    </p>

                    <div>
                        <a href="{{ route('coach.courses.manage', $course) }}" class="btn btn-sm btn-outline-secondary">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">You are not instructing any courses yet.</p>
        @endforelse
    </div>
    {{ $courses->links() }}
@endsection
