@extends('layouts.student')
@php($sidebarActive = 'dashboard')

@section('title', 'Student Dashboard')

@section('student-content')
    <h1 class="h3 mb-4">Courses you are enrolled in:</h1>

    @forelse($courses as $course)
        {{-- … karta kurzu (beze změny) … --}}
    @empty
        <p class="text-muted">You are not enrolled in any course yet.</p>
    @endforelse
@endsection
