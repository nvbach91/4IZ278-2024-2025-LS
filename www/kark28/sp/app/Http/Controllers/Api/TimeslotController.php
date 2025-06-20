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
                    'start_time' => Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $slot->start_time,
                        'Europe/Prague'
                    )
                    ->setTimezone('UTC')
                    ->toIso8601ZuluString(),
                    'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
                    'available' => $slot->available,
                ];
            });

        return response()->json([
            'html' => View::make('partials.timeslots', ['slots' => $slots])->render()
        ]);
    }

    public function availableDates($id)
    {
        $service = Service::with('timeslots')->findOrFail($id);

        $today = \Carbon\Carbon::today();

        $dates = $service->timeslots
            ->where('available', true)
            ->map(function ($slot) {
                return \Carbon\Carbon::parse($slot->start_time)->toDateString();
            })
            ->filter(function ($date) use ($today) {
                return $date >= $today->toDateString();
            })
            ->unique()
            ->sort()
            ->values();

        return response()->json([
            'dates' => $dates,
        ]);
    }
}
