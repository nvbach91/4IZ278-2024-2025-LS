<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $service = Service::with(['timeslots', 'business'])->findOrFail($id);
        return view('service.show', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $service = Service::with(['timeslots'])->findOrFail($id);
        return view('business.service', compact('service'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function saveTimeSlots(Request $request, $id)
    {

        $service = Service::findOrFail($id);
        $providerId = $request->input('provider_id');

        $dateFrom = Carbon::parse($request->input('date_from'));
        $dateTo = Carbon::parse($request->input('date_to'));
        $timeFrom = Carbon::parse($request->input('time_from'));
        $timeTo = Carbon::parse($request->input('time_to'));

        $slots = $this->generateTimeSlots($dateFrom, $dateTo, $timeFrom, $timeTo, $service->duration_minutes);

        $createdCount = 0;

        foreach ($slots as $slot) {
            $exists = $service->timeslots()
                ->where('start_time', $slot['start_time'])
                ->where('end_time', $slot['end_time'])
                ->where('provider_id', $providerId)
                ->exists();

            if (!$exists) {
                $service->timeslots()->create([
                    'provider_id' => $providerId,
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'available' => true,
                ]);
                $createdCount++;
            }
        }


        return redirect()->route('business.show', ['id' => $service->business_id])
            ->with('success', "Successfully created {$createdCount} time slots.");
    }

    protected function generateTimeSlots(Carbon $dateFrom, Carbon $dateTo, Carbon $timeFrom, Carbon $timeTo, int $duration)
    {


        $slots = [];
        $period = CarbonPeriod::create($dateFrom, $dateTo);

        foreach ($period as $date) {
            $startTime = $date->copy()->setTimeFrom($timeFrom);
            $endLimit = $date->copy()->setTimeFrom($timeTo);

            while (true) {
                $slotEnd = $startTime->copy()->addMinutes($duration);

                if ($slotEnd > $endLimit) {
                    break;
                }

                $slots[] = [
                    'start_time' => $startTime->copy(),
                    'end_time' => $slotEnd->copy(),
                ];

                $startTime = $slotEnd;
            }
        }

        return $slots;
    }

    public function editTime(Service $service, $date)
    {
        $slots = $service->timeslots()
            ->whereDate('start_time', $date)
            ->orderBy('start_time')
            ->get();

        return view('business.show', compact('service', 'slots', 'date'));
    }

    public function deleteTimeslots(Request $request, $id)
    {
        $date = $request->query('date'); // comes from URL like ?date=2025-06-01

        $service = Service::with('timeslots')->findOrFail($id);

        if (!$date) {
            return redirect()->back()->withErrors('Datum není zadáno.');
        }

        $start = \Carbon\Carbon::parse($date)->startOfDay();
        $end = \Carbon\Carbon::parse($date)->endOfDay();

        $deletedCount = $service->timeslots()
            ->whereBetween('start_time', [$start, $end])
            ->delete();

        return redirect()->back()->with('success', "Smazáno $deletedCount časových slotů pro datum " . \Carbon\Carbon::parse($date)->format('d.m.Y'));
    }
}
