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
                        <button type="button" class="btn btn-outline-danger" onclick="confirmAccountDeletion()">Smazat
                            účet</button>
                        <div class="text-end">

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
                    <h2 id="reservations">Aktivní Rezervace</h2>
                    <hr>

                    @forelse ($activeReservations as $reservation)
                        <div class="border rounded p-3 mb-3 bg-white shadow-sm">

                            {{-- ID + Badge --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="mb-0">
                                    <span>ID rezervace:</span> {{ $reservation->id }}
                                </p>
                                <span
                                    class="badge bg-{{ match ($reservation->status) {
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'completed' => 'primary',
                                        'cancelled' => 'danger',
                                        default => 'light',
                                    } }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </div>

                            {{-- Business + Služba --}}
                            <p class="fw-semibold fs-5 mb-1">
                                {{ $reservation->timeslot->service->business->name ?? 'Neznámý business' }}
                            </p>
                            <p class="mb-2">
                                {{ $reservation->timeslot->service->name ?? 'Neznámá služba' }}
                            </p>

                            {{-- Cena --}}
                            @if (!empty($reservation->timeslot->service->price))
                                <p class="mb-2">
                                    Cena: {{ number_format($reservation->timeslot->service->price, 0, ',', ' ') }} Kč
                                </p>
                            @endif


                            {{-- Čas rezervace + Vytvořeno --}}
                            @if ($reservation->timeslot)
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-0 fw-semibold text-primary">
                                        <span>Čas rezervace:</span>
                                        {{ $reservation->timeslot->start_time->format('d.m.Y H:i') }} –
                                        {{ $reservation->timeslot->end_time->format('H:i') }}
                                    </p>
                                    <p class="mb-0 text-muted fst-italic small">
                                        Vytvořeno: {{ $reservation->created_at?->format('d.m.Y H:i') ?? 'N/A' }}
                                    </p>
                                </div>
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
                            <div class="opacity-50">
                                {{-- ID + Badge --}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="mb-0">
                                        <span>ID rezervace:</span> {{ $reservation->id }}
                                    </p>
                                    <span
                                        class="badge bg-{{ match ($reservation->status) {
                                            'pending' => 'warning',
                                            'confirmed' => 'success',
                                            'completed' => 'primary',
                                            'cancelled' => 'danger',
                                            default => 'light',
                                        } }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </div>

                                {{-- Business + Služba --}}
                                <p class="fw-semibold fs-5 mb-1">
                                    {{ $reservation->timeslot->service->business->name ?? 'Neznámý business' }}
                                </p>
                                <p class="mb-2">
                                    {{ $reservation->timeslot->service->name ?? 'Neznámá služba' }}
                                </p>

                                {{-- Čas rezervace + Vytvořeno --}}
                                @if ($reservation->timeslot)
                                    <div class="d-flex justify-content-between align-items-start">
                                        <p class="mb-0 fw-semibold">
                                            <span>Čas rezervace:</span>
                                            {{ $reservation->timeslot->start_time->format('d.m.Y H:i') }} –
                                            {{ $reservation->timeslot->end_time->format('H:i') }}
                                        </p>

                                        <div class="text-end">
                                            <p class="mb-1 text-muted fst-italic small">
                                                Vytvořeno: {{ $reservation->created_at?->format('d.m.Y H:i') ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted">Tato rezervace nemá přiřazený časový slot.</p>
                                @endif
                            </div>

                            @if (!empty($reservation->show_review_button))
                                <div class="text-end mt-2">
                                    <a href="{{ route('reviews.create', ['business_id' => $reservation->timeslot->service->business->id]) }}"
                                        class="btn btn-primary">
                                        Leave a Review
                                    </a>
                                </div>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.confirmAccountDeletion = async function() {
                const params = {
                    title: 'Smazat účet',
                    message: 'Opravdu chcete svůj účet smazat? Tato akce je nevratná.',
                    action: deleteProfileEndpoint,
                    method: 'DELETE',
                    confirmText: 'Smazat účet'
                };

                try {
                    const overlayUrl = new URL(overlayConfirmEndpoint, window.location.origin);
                    overlayUrl.search = new URLSearchParams(params).toString();

                    const response = await fetch(overlayUrl);
                    if (!response.ok) throw new Error(`Chyba: ${response.status}`);
                    const html = await response.text();
                    showOverlay(html);

                } catch (err) {
                    console.error(err);
                    alert('Nepodařilo se načíst potvrzovací dialog.');
                }
            };

            const overlayConfirmEndpoint = "{{ route('overlay.confirm') }}";
            const deleteProfileEndpoint = "{{ route('profile.destroy') }}";
        });
    </script>
@endpush
