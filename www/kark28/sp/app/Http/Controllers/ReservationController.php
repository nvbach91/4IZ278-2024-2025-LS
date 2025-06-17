<?php

namespace App\Http\Controllers;

use App\Models\Timeslot;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index($businessId, Request $request)
    {
        $business = \App\Models\Business::with([
            'services.timeslots.reservations.user',
            'services.timeslots.service'
        ])->findOrFail($businessId);

        $allowedRoles = ['owner', 'manager', 'worker'];

        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        abort_unless(
            $currentUser instanceof User
                && $currentUser->hasRoleAtBusiness($business, $allowedRoles),
            403,
            'Nemáte oprávnění zobrazit tento byznys.'
        );

        $reservations = collect();

        foreach ($business->services as $service) {
            foreach ($service->timeslots as $timeslot) {
                foreach ($timeslot->reservations as $reservation) {
                    $reservation->timeslot = $timeslot;
                    $reservation->service = $service;
                    $reservations->push($reservation);
                }
            }
        }
        $this->markPastReservationsCompleted($reservations);

        // Filtrování podle statusu
        if ($request->has('filter') && in_array($request->query('filter'), ['pending', 'confirmed', 'completed', 'cancelled'])) {
            $reservations = $reservations->filter(fn($res) => $res->status === $request->query('filter'));
        }

        // Rozdělení na nadcházející a minulé
        $now = now();
        $upcoming = $reservations->filter(fn($res) => $res->timeslot->start_time->isFuture());
        $past = $reservations->filter(fn($res) => $res->timeslot->start_time->isPast());

        return view('business.reservations.index', [
            'business' => $business,
            'upcoming' => $upcoming,
            'past' => $past
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'slot_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $slot = Timeslot::where('id', $request->slot_id)
            ->where('service_id', $request->service_id)
            ->whereDate('start_time', $request->date)
            ->where('available', true)
            ->first();

        if (!$slot) {
            return redirect()->back()->with('error', 'Vybraný časový slot není dostupný.');
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'service_id' => $request->service_id,
            'timeslot_id' => $slot->id,
            'date' => $request->date,
        ]);

        $slot->available = false;
        $slot->save();

        return redirect()->to(route('user.profile') . '#reservations')->with('success', 'Rezervace byla úspěšně vytvořena a čeká na potvrzení.');
    }

    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if (!$reservation->timeslot->service->business->business_managers->contains('user_id', auth()->id())) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $reservation->status = $request->status;
        $reservation->save();

        return back()->with('success', 'Stav rezervace byl aktualizován.');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        if (!$reservation->timeslot->service->business->business_managers->contains('user_id', auth()->id())) {
            abort(403);
        }

        $reservation->delete();

        return back()->with('success', 'Rezervace byla smazána.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'reservation_ids' => 'required|array',
            'reservation_ids.*' => 'integer|exists:reservations,id',
            'action_type' => 'required|in:confirm,cancel',
        ]);

        $reservations = Reservation::whereIn('id', $request->reservation_ids)->get();

        foreach ($reservations as $reservation) {
            if ($reservation->timeslot->service->business->business_managers->contains('user_id', auth()->id())) {
                $reservation->status = $request->action_type === 'confirm' ? 'confirmed' : 'cancelled';
                $reservation->save();
            }
        }

        return back()->with('success', 'Vybrané rezervace byly úspěšně zpracovány.');
    }

    protected function markPastReservationsCompleted($reservations)
    {
        foreach ($reservations as $res) {
            // Kontrola, že timeslot existuje a end_time je instance Carbon
            if ($res->timeslot && $res->timeslot->end_time instanceof \Carbon\Carbon) {
                $endTime = $res->timeslot->end_time;

                if ($endTime->isPast() && $res->status !== 'cancelled' && $res->status !== 'completed') {
                    Reservation::where('id', $res->id)
                        ->update(['status' => 'completed']);
                    $res->refresh();
                }
            }
        }
    }

  public function getUserReservationsGroupedByTime($user): array
{
    $reservations = $user->reservations()
        ->with('timeslot.service.business')
        ->get();

    $now = now();
    $this->markPastReservationsCompleted($reservations);

    $activeReservations = $reservations->filter(function ($reservation) use ($now) {
        return $reservation->timeslot && $reservation->timeslot->start_time > $now;
    })->sortBy(function ($reservation) {
        return $reservation->timeslot->start_time ?? now();
    })->values();

    $pastReservations = $reservations->filter(function ($reservation) use ($now) {
        return !$reservation->timeslot || $reservation->timeslot->start_time <= $now;
    })->sortByDesc(function ($reservation) {
        return $reservation->timeslot->start_time ?? now();
    })->values();

    // Check which businesses the user already reviewed
    $reviewedBusinessIds = $user->reviews()->pluck('business_id')->toArray();

    // Find the first past reservation where user hasn't reviewed the business yet
    foreach ($pastReservations as $reservation) {
        $business = optional($reservation->timeslot?->service?->business);
        if ($business && !in_array($business->id, $reviewedBusinessIds)) {
            $reservation->show_review_button = true;
            break;
        }
    }

    return [
        'active' => $activeReservations,
        'past' => $pastReservations,
    ];
}

}
