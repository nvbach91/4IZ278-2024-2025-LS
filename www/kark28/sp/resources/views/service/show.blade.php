@extends('layouts.app')


@section('title', 'Rezervace | Rezervační systém')

@section('content')
    @include('service.confirm-reservation')
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
                        <input type="date" id="datePicker" class="form-control" data-service-id="{{ $service->id }}" />
                    </div>

                    <div id="timeslotContainer">
                        <p class="text-muted">Vyberte datum pro zobrazení dostupných časů.</p>
                    </div>
                    <button onclick="showOverlay()"
                        class=" btn btn-primary d-flex justify-content-end gap-2 mt-3">Rezervovat</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const BASE_URL = "{{ url('') }}";
        const CONFIRM_RESERVATION_URL = "{{ route('reservation.confirm') }}";
    </script>

    <script src="{{ asset('js/service-timeslot.js') }}"></script>
    <script src="{{ asset('js/overlay.js') }}"></script>

@endsection
