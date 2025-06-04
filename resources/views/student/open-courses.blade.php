@extends('layouts.student')
@php($sidebarActive = 'open')

@section('title', 'Open Courses')

@section('student-content')
    <h1 class="h3 mb-4">Open courses</h1>

    @forelse($courses as $course)
        {{-- … karta kurzu + tlačítko Enroll … --}}
    @empty
        <p class="text-muted">Momentálně nejsou žádné otevřené kurzy.</p>
    @endforelse
@endsection
