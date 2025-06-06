@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<section class="container py-5 d-flex flex-column flex-lg-row align-items-center justify-content-between">
    {{-- LEVÁ STRANA – text --}}
    <div class="me-lg-5 text-center text-lg-start mb-4 mb-lg-0" style="max-width: 500px;">
        <h1 class="display-5">Welcome</h1>

        <p class="lead">
            Manage courses, lessons &amp; homework in one simple place.
        </p>

        <div class="mt-3">
            <a href="{{ secure_url('student/register') }}" class="btn btn-primary me-2">Začít zdarma</a>
        </div>
    </div>

    {{-- PRAVÁ STRANA – carousel --}}
    <div class="w-100" style="max-width: 720px;">
        <div id="landingCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="carousel-item {{ $i === 1 ? 'active' : '' }}">
                        <img
                            src="{{ secure_asset('images/landing-' . $i . '.jpg') }}"
                            class="d-block w-100"
                            alt="slide {{ $i }}"
                            style="height: 360px; object-fit: cover;"
                        >
                    </div>
                @endfor
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#landingCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#landingCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
    @php
    $courses = \App\Models\Course::with(['coach','lessons'])->take(3)->get();
    @endphp

    <section class="featured-courses mt-5">
        <h2 class="mb-4">Featured Courses</h2>
        <div class="row">
            @foreach($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <p class="card-text">
                            {{ \Illuminate\Support\Str::limit($course->description, 100) }}
                        </p>
                        <p>
                            <strong>Coach:</strong>
                            {{ $course->coach->name ?? 'N/A' }}
                        </p>
                        <p>
                            <strong>Start Date:</strong>
                            {{ $course->start_date ? $course->start_date->format('j.n.Y') : 'N/A' }}
                        </p>
                        @php
                        $nextLesson = $course->lessons
                        ->where('scheduled_at', '>=', now())
                        ->sortBy('scheduled_at')
                        ->first();
                        @endphp
                        <p>
                            <strong>Next Lesson:</strong>
                            @if ($nextLesson)
                            {{ $nextLesson->scheduled_at->format('j.n.Y') }}
                            @else
                            No upcoming lesson
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

@endsection
