@php
    use Carbon\Carbon;
    $now = Carbon::now();
@endphp

@if ($slots->isEmpty())
    <p class="text-muted">Žádné dostupné časy pro tento den.</p>
@else
    <div class="d-flex flex-wrap gap-2">
       @foreach ($slots as $slot)
    <button 
        class="btn timeslot-btn rounded-pill px-3 py-2 btn-outline-primary" 
        data-slot-id="{{ $slot['id'] }}" 
        data-datetime="{{ $slot['start_time'] }}">
        {{ \Carbon\Carbon::parse($slot['start_time'])
            ->setTimezone('Europe/Prague')
            ->format('H:i') }}
    </button>
@endforeach

    </div>
@endif
