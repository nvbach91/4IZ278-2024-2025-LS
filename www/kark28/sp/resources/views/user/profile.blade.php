@extends('layouts.app')

@section('title', 'Můj profil | Rezervační systém')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="border rounded p-4 bg-light shadow-sm">
                    <h2>Můj Profil</h2>
                    <hr>
                    <form class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Jméno</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}" readonly>

                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>

                        </div>
                        <button type="button" class="btn btn-outline-danger">Smazat účet</button>
                        <div class="text-end">
                            <!--<button type="button" class="btn btn-secondary">Zrušit</button>
                                                <button type="submit" class="btn btn-primary">Změnit</button> -->
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
                    <h2>Aktivní Rezervace</h2>
                    <hr>

                    @forelse ($activeReservations as $reservation)
                        <div class="border rounded p-3 mb-3 bg-white shadow-sm">
                            <p><strong>ID rezervace:</strong> {{ $reservation->id }}</p>
                            <p><strong>Status:</strong> {{ $statusTranslations[$reservation->status] ?? 'Neznámý' }}</p>
                            <p><strong>Vytvořeno:</strong>
                                {{ $reservation->created_at?->format('d.m.Y H:i') ?? 'N/A' }}
                            </p>

                            @if ($reservation->timeslot)
                                <p><strong>Čas rezervace:</strong>
                                    {{ $reservation->timeslot->start_time->format('d.m.Y H:i') }}
                                    –
                                    {{ $reservation->timeslot->end_time->format('H:i') }}
                                </p>
                                <p><strong>Business:</strong>
                                    {{ $reservation->timeslot->service->business->name ?? 'Neznámý business' }}
                                </p>
                                <p><strong>Služba:</strong>
                                    {{ $reservation->timeslot->service->name ?? 'Neznámá služba' }}
                                </p>
                            @else
                                <p class="text-muted">Tato rezervace nemá přiřazený časový slot.</p>
                            @endif
                        </div>

                    @empty
                        <p>Nemáte žádné aktivní rezervace.</p>
                    @endforelse

                    <h2>Minulé Rezervace</h2>
                    <hr>

                    @forelse ($pastReservations as $reservation)
                        <div class="border rounded p-3 mb-3 bg-white shadow-sm">
                            <p><strong>ID rezervace:</strong> {{ $reservation->id }}</p>

                            <p><strong>Status:</strong> {{ $statusTranslations[$reservation->status] ?? 'Neznámý' }}</p>
                            <p><strong>Vytvořeno:</strong>
                                {{ $reservation->created_at?->format('d.m.Y H:i') ?? 'N/A' }}
                            </p>

                            @if ($reservation->timeslot)
                                <p><strong>Čas rezervace:</strong>
                                    {{ $reservation->timeslot->start_time->format('d.m.Y H:i') }}
                                    –
                                    {{ $reservation->timeslot->end_time->format('H:i') }}
                                </p>
                                <p><strong>Business:</strong>
                                    {{ $reservation->timeslot->service->business->name ?? 'Neznámý business' }}
                                </p>
                                <p><strong>Služba:</strong>
                                    {{ $reservation->timeslot->service->name ?? 'Neznámá služba' }}
                                </p>
                            @else
                                <p class="text-muted">Tato rezervace nemá přiřazený časový slot.</p>
                            @endif
                        </div>

                    @empty
                        <p>Nemáte žádné předešlé rezervace.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="border rounded p-4 bg-light shadow-sm">
                    <h2>Můj Business</h2>
                    <hr>

                    @unless (Auth::user()->ownedBusiness())
                        <a href="{{ route('business.create') }}" type="button" class="btn btn-primary w-100">Vytvořit
                            Business</a>
                    @endunless
                    @if (Auth::user()->ownedBusiness())
                        <a href="{{ route('business.show', Auth::user()->ownedBusiness()->id) }}"
                            class="d-flex align-items-center icon-link btn btn-secondary">
                            <i class="fa-solid fa-briefcase"></i>
                            {{ Auth::user()->ownedBusiness()->name }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/profile.js') }}"></script>
@endsection
