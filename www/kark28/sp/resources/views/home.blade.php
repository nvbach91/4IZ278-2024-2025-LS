@extends('layouts.app')


@section('title', 'Rezervační systém')
@section('content')

<div class="container mt-5">
    <div class="row">
        @foreach ($businesses as $business)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://placehold.co/300x150" class="card-img-top" alt="Business image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $business->name }}</h5>
                        
                        <p class="card-text">{{ Str::limit($business->description, 100) }}</p>
                        <p class="text-muted mb-1">Vlastník: <strong>{{ $business->business_managers->first()?->user->name ?? 'Neznámý' }}</strong></p>
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


                        <a href="{{ route('business.show', ['id' => $business->id]) }}" class="btn btn-primary mt-auto">View Profile</a>
                    </div>
                </div>
            </div>
        @endforeach
          <div class="d-flex justify-content-center mt-4">
        {{ $businesses->links() }}
    </div>
  
</div>

@endsection