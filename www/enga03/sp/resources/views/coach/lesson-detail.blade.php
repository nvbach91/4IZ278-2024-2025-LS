{{-- resources/views/coach/lesson-detail.blade.php --}}
@extends('layouts.coach')
@php($sidebarActive = 'dashboard') {{-- Nebo změňte na 'courses' pokud máte v sidebaru speciální aktivní položku pro lekce --}}

@section('title', 'Lesson Detail')

@section('coach-content')
    <div class="vstack gap-4">

        {{-- Hlavička: Název lekce + tlačítko „Back“ --}}
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0">{{ $lesson->title }}</h1>
                @if($lesson->scheduled_at)
                    <p class="text-muted small">Scheduled: {{ $lesson->scheduled_at->format('j.n.Y H:i') }}</p>
                @endif
            </div>
            <a href="{{ route('coach.courses.manage', $lesson->course) }}" class="btn btn-sm btn-outline-secondary">
                ← Back to Course
            </a>
        </div>

        {{-- Popis lekce --}}
        <section class="card p-4">
            <h2 class="h5 mb-2">Lesson Description</h2>
            @if(trim($lesson->description))
                <p class="mb-0">
                    {{ $lesson->description }}
                </p>
            @else
                <p class="text-muted">No description provided for this lesson.</p>
            @endif
        </section>

        {{-- Zadání domácího úkolu --}}
        @if($lesson->homework)
            <section class="card p-4">
                <h2 class="h5 mb-2">Homework Assignment</h2>
                <p class="mb-0">
                    {{ $lesson->homework->instructions }}
                </p>
                @if($lesson->homework->due_date)
                    <p class="text-muted small mt-1">
                        Due date: {{ $lesson->homework->due_date->format('j.n.Y') }}
                    </p>
                @endif
            </section>
        @else
            <section class="card p-4">
                <p class="text-muted">No homework assigned for this lesson.</p>
            </section>
        @endif

        {{-- Seznam odevzdaných úkolů studentů --}}
        <section>
            <h2 class="h5 mb-3">Student Submissions</h2>

            @if($lesson->submissions->isEmpty())
                <p class="text-muted">No submissions yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Submitted At</th>
                                <th>File</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lesson->submissions as $index => $submission)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $submission->student->name }}</td>
                                    <td class="text-muted small">
                                        {{ $submission->created_at 
                                            ? $submission->created_at->format('j.n.Y H:i') 
                                            : '–' 
                                        }}
                                    </td>

                                    <td>
                                        @if($submission->file_path)
                                            <a href="{{ asset('storage/' . $submission->file_path) }}" class="link-primary" target="_blank">
                                                Download
                                            </a>
                                        @else
                                            <span class="text-muted">No file</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('coach.submissions.grade', $submission) }}" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <select name="grade" class="form-select form-select-sm">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ $submission->grade == $i ? 'selected' : '' }}>{{ $i }}★</option>
                                                @endfor
                                            </select>
                                            <button type="submit" class="btn btn-sm ms-2 btn-primary">Save</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        {{-- Tlačítko pro úpravu lekce (případně přidání/úpravu homework) --}}
        <section>
            @if(Route::has('coach.lessons.edit'))
                <a href="{{ route('coach.lessons.edit', $lesson) }}" class="btn btn-primary">
                    Edit Lesson
                </a>
            @endif
        </section>

    </div>
@endsection
