@if ($slots->isEmpty())
    <p class="text-muted">Žádné dostupné časy pro tento den.</p>
@else
    <div class="d-flex flex-wrap gap-2">
        @foreach ($slots as $slot)
            <button
                class="btn timeslot-btn rounded-pill px-3 py-2 {{ $slot['available'] ? 'btn-outline-primary' : 'btn-outline-secondary disabled text-muted' }}"
                data-slot-id="{{ $slot['id'] }}" {{ !$slot['available'] ? 'disabled' : '' }}>
                {{ $slot['start_time'] }}
            </button>
        @endforeach
    </div>
@endif
