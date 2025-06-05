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
            <a href="{{ route('student.register.show') }}" class="btn btn-primary me-2">Začít zdarma</a>
            <a href="" class="btn btn-outline-secondary">Přihlásit se</a>
        </div>
    </div>

    {{-- PRAVÁ STRANA – carousel --}}
    <div class="w-100" style="max-width: 720px;">
        <div id="landingCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="carousel-item {{ $i === 1 ? 'active' : '' }}">
                        <img src="{{ asset("images/landing-$i.jpg") }}" class="d-block w-100" alt="slide {{ $i }}" style="height: 360px; object-fit: cover;">
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

@endsection
