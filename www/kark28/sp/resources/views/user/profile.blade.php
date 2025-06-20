@extends('layouts.app')

@section('title', 'Můj profil | Rezervační systém')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="border rounded p-4 bg-light shadow-sm">
                    <h2 id="profile">Můj Profil</h2>
                    <hr>
                    <form class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Jméno</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" readonly disabled>

                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly
                                disabled>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="border rounded p-4 bg-light shadow-sm">
                    <h2 id="reservations">Moje Rezervace</h2>
                    <hr>
                   <a href="{{ route('user.reservations') }}" class="btn btn-outline-secondary">
                            Zobrazit rezervace
                        </a>

                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="border rounded p-4 bg-light shadow-sm">
                    <h2 id="business">Můj Business</h2>
                    <hr>

                    @php
                        $myBusiness = Auth::user()->ownedBusiness();
                        $managed = Auth::user()->managedBusinesses();
                    @endphp

                    {{-- Owned Business --}}
                    @unless ($myBusiness)
                        <a href="{{ route('business.create') }}" type="button" class="btn btn-primary w-100 mb-3 text-center">
                            Vytvořit Business
                        </a>
                    @else
                        <a href="{{ route('business.show', $myBusiness->id) }}"
                            class="btn btn-secondary w-100 mb-3 text-center">
                            <i class="fa-solid fa-briefcase me-2"></i>
                            {{ $myBusiness->name }}
                        </a>
                    @endunless

                    {{-- Managed Businesses --}}
                    <h2 class="mt-4">Spravuji</h2>
                    <hr>

                    @forelse($managed as $biz)
                        <a href="{{ route('business.show', $biz->id) }}"
                            class="btn btn-outline-secondary w-100 mb-2 text-center">
                            <i class="fa-solid fa-briefcase me-2"></i>
                            {{ $biz->name }}
                        </a>
                    @empty
                        <p class="text-muted">Nejste manažerem žádného businessu.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
