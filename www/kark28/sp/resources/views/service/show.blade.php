@extends('layouts.app')

@section('title', 'Rezervace | Rezervační systém')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none mb-3">
                    <i class="fas fa-chevron-left"></i> Zpět
                </a>
                <h1 class="mb-4">{{ $service->business->name ?? 'Neznámý podnik' }}</h1>
                <br>
                <div class="border rounded p-4 bg-light shadow-sm">


                    <h2>Rezervovat - {{ $service->name }}</h2>
                    <p>{{ $service->description }}</p>
                    <p><strong>Délka trvání služby:</strong> {{ $service->duration_minutes }} min</p>

                    <hr>

                    <div class="mb-3">
                        <label for="datePicker" class="form-label">Vybrat datum:</label>
                        <input type="text" id="datePicker" class="form-control" data-service-id="{{ $service->id }}" />

                    </div>

                    <div id="timeslotContainer">
                        <p class="text-muted">Vyberte datum pro zobrazení dostupných časů.</p>
                    </div>
                    <button onclick="handleReservationClick()"
                        class=" btn btn-primary d-flex justify-content-end gap-2 mt-3">Rezervovat</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.SERVER_NOW = "{{ \Carbon\Carbon::now('Europe/Prague')->format('Y-m-d\\TH:i:sP') }}";

        function handleReservationClick() {
            const datePicker = document.getElementById('datePicker');
            const serviceId = datePicker?.dataset.serviceId;
            const date = datePicker?.value;

            if (!selectedTimeSlot || !date || !serviceId || !selectedSlotId) {
                alert("Prosím vyberte datum a čas.");
                return;
            }

            openReservationOverlay(serviceId, date, selectedTimeSlot, selectedSlotId);
        }

        function openReservationOverlay(serviceId, date, time, slotId) {
            const params = new URLSearchParams({
                type: 'reservation',
                service_id: serviceId,
                date: date,
                time: time,
                slot_id: slotId
            });

            fetch(`{{ route('overlay.confirm') }}?` + params.toString())
                .then(res => res.text())
                .then(html => showOverlay(html));
        }
    </script>

    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/service-timeslot.js') }}"></script>
@endsection
