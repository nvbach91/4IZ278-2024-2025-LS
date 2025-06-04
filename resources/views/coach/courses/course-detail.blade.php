{{-- resources/views/coach/course-detail.blade.php --}}
@extends('layouts.coach')
@php($sidebarActive = 'dashboard')

@section('title', 'Course Detail')

@section('coach-content')
    <div class="space-y-8">

        {{-- Název kurzu a tlačítko zpět --}}
        <div class="flex justify-between items-center">
            <h1 class="text-4xl font-bold">{{ $course->name }}</h1>
            <a href="{{ route('coach.dashboard') }}" class="btn btn-sm btn-outline">
                ← Back to Dashboard
            </a>
        </div>

        {{-- Popis kurzu --}}
        <section class="card p-4">
            <h2 class="text-2xl font-semibold mb-2">Description</h2>
            @if(trim($course->description))
                <p class="mb-0">
                    {{ $course->description }}
                </p>
            @else
                <p class="text-sm opacity-60">No description provided.</p>
            @endif
        </section>

        {{-- Sekce: Lekce --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4">Lessons</h2>

            @if($course->lessons->isEmpty())
                <p class="text-sm opacity-60 text-white">No lessons created yet.</p>
            @else
                <div class="vstack gap-3">
                    @foreach($course->lessons as $lesson)
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="card-title">{{ $lesson->title }}</h3>
                                    <p class="text-xs opacity-60">
                                        Scheduled: {{ $lesson->scheduled_at?->format('j.n.Y') ?? 'TBA' }}
                                    </p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('coach.lessons.show', $lesson) }}" class="btn btn-sm btn-outline">View</a>
                                    <a href="{{ route('coach.lessons.edit', $lesson) }}" class="btn btn-sm">Edit</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- Sekce: Enrolled Students --}}
        <section>
            <h2 class="text-2xl font-semibold mb-4">Enrolled Students</h2>

            @if($course->students->isEmpty())
                <p class="text-sm opacity-60 text-white">No students enrolled.</p>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Enrolled at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course->students as $index => $student)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td class="text-xs opacity-60">
                                        {{ $student->pivot->created_at?->format('j.n.Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        {{-- Tlačítko pro úpravu kurzu --}}
        <section>
            <a href="{{ route('coach.courses.edit', $course) }}" class="btn btn-primary">
                Edit Course
            </a>
        </section>

    </div>
@endsection
