@extends('layouts.app')

@section('content')


@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<div class="w-100 px-3 mt-3">
    <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none">
        <i class="fas fa-chevron-left"></i> Zpět
    </a>
</div>

<div class="container mt-4">

    <h1>{{ $business->name }}</h1>
    <p>{{ $business->description }}</p>

    <hr>

    <!-- Main Content -->
    <div class="row mt-3" style="min-height: 70vh;">
        <div class="col-md-6 bg-light p-3">
            <h3>Služby</h3>
                <div class="row">
                    @foreach($business->services as $service)
                <div class="col-12 mb-3">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column p-3" style="font-size: 0.9rem;">
                                <div>
                                    <h6 class="card-title mb-2">{{ $service->name }}</h6>
                                    <p class="card-text mb-1">{{ $service->description }}</p>
                                    <p class="card-text mb-2"><strong>Cena:</strong> {{ $service->price }} Kč</p>
                                </div>
                                <div class="mt-auto d-flex justify-content-end">
                                    <a href="#" class="btn btn-sm btn-primary">Rezervovat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>


        <div class="col-md-6">
            <div class="right-column h-100">
                <div class="bg-light p-3">
                    <h3>Majitel a tým</h3>
                    @foreach($business->business_managers as $manager)
    <li class="mb-2 d-flex justify-content-between align-items-center">
        <div>
            <strong>{{ $manager->user->name ?? 'Neznámý uživatel' }}</strong><br>
            <small class="text-muted">{{ $manager->user->email ?? '—' }}</small>
        </div>
        <span class="badge bg-primary">{{ ucfirst($manager->permission_level) }}</span>
    </li>
@endforeach

                </div>
                <br>
<div class="bg-light p-3">
    <h3>Hodnocení</h3>
    @if($business->reviews->isEmpty())
        <p>No reviews yet.</p>
    @else
        @foreach($business->reviews as $review)
            <div class="card mb-2">
                <div class="card-body">
                    <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>

                    {{-- Star Rating --}}
                    <div class="mb-1">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                    </div>

                    <p class="mb-1">{{ $review->comment }}</p>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->format('d.m.Y') }}</small>
                </div>
            </div>
        @endforeach
    @endif
</div>

                
            </div>
        </div>
    </div>
</div>
@endsection
