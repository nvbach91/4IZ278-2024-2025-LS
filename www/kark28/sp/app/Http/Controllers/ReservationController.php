<?php

namespace App\Http\Controllers;

use App\Models\Timeslot;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
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

        return redirect()->route('user.profile')->with('success', 'Rezervace byla úspěšně vytvořena a čeká na potvrzení.');
    }
}
