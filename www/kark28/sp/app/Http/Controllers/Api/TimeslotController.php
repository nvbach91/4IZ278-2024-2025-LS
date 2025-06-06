<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;

use Illuminate\Support\Facades\View;


class TimeslotController extends Controller
{

    public function getByDate($id, Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json(['error' => 'Date is required'], 400);
        }

        $service = Service::with('timeslots')->findOrFail($id);

        $slots = $service->timeslots
            ->whereBetween('start_time', [
                Carbon::parse($date)->startOfDay(),
                Carbon::parse($date)->endOfDay()
            ])
            ->sortBy('start_time')
            ->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                    'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
                    'available' => $slot->available,
                ];
            });

        return response()->json([
            'html' => View::make('partials.timeslots', ['slots' => $slots])->render()
        ]);
    }
}
