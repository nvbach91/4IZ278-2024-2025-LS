@extends('layouts.app')


@section('title', 'Rezervační systém')
@section('content')

    <div class="container mt-5">
        <form method="GET" action="{{ route('home') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Hledat podnik..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Nejnovější
                        </option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Název A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Název Z-A</option>
                        <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Nejlépe
                            hodnocené</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filtrovat</button>
                </div>
            </div>
        </form>

        <div class="row">
            @foreach ($businesses as $business)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="https://placehold.co/300x150" class="card-img-top" alt="Business image">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $business->name }}</h5>

                            <p class="card-text">{{ Str::limit($business->description, 100) }}</p>
                            <p class="text-muted mb-1">Vlastník:
                                <strong>{{ $business->business_managers->first()?->user->name ?? 'Neznámý' }}</strong></p>
                            @php
                                $avgRating = $business->reviews->avg('rating');
                            @endphp

                            <div class="mb-2 text-warning">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($avgRating))
                                        ★
                                    @else
                                        ☆
                                    @endif
                                @endfor
                                <span class="text-muted small">({{ number_format($avgRating, 1) ?? '0.0' }})</span>
                            </div>


                            <a href="{{ route('business.show', ['id' => $business->id]) }}"
                                class="btn btn-primary mt-auto">View Profile</a>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="d-flex justify-content-center mt-4">
                {{ $businesses->appends(request()->query())->links() }}

            </div>

        </div>

    @endsection
