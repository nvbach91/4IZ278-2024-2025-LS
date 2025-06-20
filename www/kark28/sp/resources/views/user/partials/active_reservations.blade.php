@forelse ($reservations as $reservation)
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
    <p>Nemáte žádné rezervace.</p>
@endforelse
