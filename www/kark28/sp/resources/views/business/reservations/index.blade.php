@extends('layouts.app')

@section('content')
    <div class="w-100 px-3 mt-3">
        <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none">
            <i class="fas fa-chevron-left"></i> Zpět
        </a>
    </div>

    <div class="container">
        <h2>Rezervace firmy: {{ $business->name }}</h2>

        <div class="mb-4">
            <form method="GET" action="{{ route('business.reservations', $business->id) }}">
                <label for="filter">Filtr podle stavu (nadcházející):</label>
                <select name="filter" id="filter" onchange="this.form.submit()">
                    <option value="">Všechny</option>
                    <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>Čekající</option>
                    <option value="confirmed" {{ request('filter') == 'confirmed' ? 'selected' : '' }}>Potvrzené</option>
                    <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>Dokončené</option>
                    <option value="cancelled" {{ request('filter') == 'cancelled' ? 'selected' : '' }}>Zrušené</option>
                </select>
            </form>
        </div>


        <form method="POST" action="{{ route('reservation.bulkAction') }}">
            @csrf
            @method('PATCH')


            <h4>Nadcházející rezervace</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>

                        <th>Stav</th>
                        <th>Služba</th>
                        <th>Uživatel</th>
                        <th>Datum</th>
                        <th>Čas</th>
                        <th>Délka</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($upcoming as $reservation)
                        <tr>
                            <td><input type="checkbox" name="reservation_ids[]" value="{{ $reservation->id }}"></td>
                            <td>
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
                            </td>
                            <td>{{ $reservation->timeslot->service->name }}</td>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->timeslot->start_time)->format('d.m.Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->timeslot->start_time)->format('H:i') }}</td>
                            <td>{{ $reservation->timeslot->service->duration_minutes }} min</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Žádné nadcházející rezervace.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


            <!-- Skryté pole pro typ akce -->
            <input type="hidden" name="action_type" id="action_type" value="">

            <!-- Tlačítka -->
            <button type="submit" class="btn btn-success" onclick="document.getElementById('action_type').value='confirm'">
                Potvrdit vybrané
            </button>
            <button type="submit" class="btn btn-danger"
                onclick="document.getElementById('action_type').value='cancel'">
                Zrušit vybrané
            </button>
        </form>


        <h4 class="mt-5">Minulé rezervace</h4>
        <table class="table table-bordered text-muted">
            <thead>
                <tr>
                    <th>Stav</th>
                    <th>Služba</th>
                    <th>Uživatel</th>
                    <th>Datum</th>
                    <th>Čas</th>
                    <th>Délka</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($past as $reservation)
                    <tr class="opacity-50">
                        <td>
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
                        </td>
                        <td>{{ $reservation->timeslot->service->name }}</td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->timeslot->start_time)->format('d.m.Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->timeslot->start_time)->format('H:i') }}</td>
                        <td>{{ $reservation->timeslot->service->duration_minutes }} min</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Žádné minulé rezervace.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('select-all')?.addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('input[name="reservation_ids[]"]');
            checkboxes.forEach(cb => cb.checked = e.target.checked);
        });
    </script>
@endsection
