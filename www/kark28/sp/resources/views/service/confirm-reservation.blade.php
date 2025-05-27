@extends('layouts.overlay')

@section('overlay')
    <h2>Potvrzení rezervace</h2>
    <p>Opravdu chcete potvrdit tuto rezervaci?</p>
    <h3>Přehled rezervace</h3>
    <hr>
    <p><strong>Podnik:</strong> {{ $service->business->name ?? 'Neznámý podnik' }}</p>
    <p><strong>Služba:</strong> {{ $service->name }}</p>
    <p><strong>Popis:</strong> {{ $service->description }}</p>
    <p><strong>Délka:</strong> {{ $service->duration_minutes }} minut</p>
    <p><strong>Cena:</strong> {{ number_format($service->price) }} Kč</p>
    <p><strong>Vybrané datum:</strong> <span id="selectedDate">–</span></p>
    <p><strong>Vybraný čas:</strong> <span id="selectedTimeSlot">–</span></p>

    <button type="submit" class="btn btn-primary" onclick="confirmReservation()">Potvrdit</button>
    <button type="button" class="btn btn-secondary" onclick="closeOverlay()">Zrušit</button>
@endsection
