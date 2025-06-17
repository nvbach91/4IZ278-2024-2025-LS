<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\BusinessManager;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function home()
    {
        $filters = request()->all();

        if (!isset($filters['sort'])) {
            $filters['sort'] = 'newest';
        }

        $businesses = Business::with(['business_managers.user', 'reviews'])
            ->filter($filters)
            ->paginate(12)
            ->appends($filters);

        return view('home', compact('businesses'));
    }



    public function show($id)
    {
        $business = Business::with([
            'services.timeslots.reservations.user',
            'business_managers' => function ($query) {
                $query->orderByRaw("FIELD(permission_level, 'owner', 'manager', 'worker')");
            },
            'business_managers.user',
            'reviews.user'
        ])->findOrFail($id);

        $currentUser = Auth::user();
        $editRole = $business->canEdit($currentUser);

        $groupedSlotsByService = [];
        foreach ($business->services as $service) {
            $grouped = $service->timeslots->groupBy(function ($slot) {
                return \Carbon\Carbon::parse($slot->start_time)->format('Y-m-d');
            });

            $groupedSlotsByService[$service->id] = $grouped->map(function ($slots, $date) {
                if (\Carbon\Carbon::parse($date)->isBefore(\Carbon\Carbon::today())) {
                    return null;
                }

                $sorted = $slots->sortBy('start_time');
                $first = $sorted->first();
                $last = $slots->sortByDesc('end_time')->first();
                $reservations = $slots->where('available', 0)->count();

                return [
                    'date' => $date,
                    'day' => \Carbon\Carbon::parse($date)->isoFormat('dd'),
                    'start' => \Carbon\Carbon::parse($first->start_time)->format('H:i'),
                    'end' => \Carbon\Carbon::parse($last->end_time)->format('H:i'),
                    'count' => $slots->count(),
                    'reservations' => $reservations,
                    'can_delete' => $reservations === 0,
                ];
            })->filter();
        }

        return view('business.show', compact('business', 'currentUser', 'editRole', 'groupedSlotsByService'));
    }


    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->ownedBusiness()) {
            return redirect()
                ->route('business.show', $user->ownedBusiness()->id)
                ->with('error', 'Už vlastníte jeden business.');
        }

        return view('business.create');
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->ownedBusiness()) {
            return redirect()
                ->route('business.show', $user->ownedBusiness()->id)
                ->with('error', 'Už vlastníte jeden business.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $business = Business::create($validated);

        BusinessManager::create([
            'business_id' => $business->id,
            'user_id' => $user->id,
            'permission_level' => 'owner',
        ]);

        return redirect()
            ->route('business.show', $business->id)
            ->with('success', 'Business byl úspěšně vytvořen!');
    }

    public function edit($id)
    {
        $business = Business::with([
            'services',
            'business_managers.user'
        ])->findOrFail($id);


        $currentUser = Auth::user();
        $editRole = $business->canEdit($currentUser);

        if (! $editRole) {
            abort(403, 'Nemáte oprávnění upravovat tento byznys.');
        }

        $roles = BusinessManager::availableRoles();

        return view('business.edit', compact('business', 'roles', 'currentUser'));
    }


    public function update(Request $request, $id)
    {
        $business   = Business::with('business_managers')->findOrFail($id);
        $currentUser = Auth::user();

        if (! $business->canEdit($currentUser)) {
            abort(403, 'Nemáte oprávnění upravovat tento byznys.');
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'services.*.id'               => 'nullable|integer|exists:services,id',
            'services.*.name'             => 'required|string|max:255',
            'services.*.description'      => 'nullable|string',
            'services.*.duration_minutes' => 'required|integer|min:1',
            'services.*.price'            => 'required|numeric|min:0',
            'managers.*.id'               => 'required|integer|exists:business_managers,id',
            'managers.*.permission_level' => 'required|in:owner,manager,worker',
            'managers.*.delete'           => 'nullable|in:0,1',
            'new_managers.*.email'        => 'nullable|email|exists:users,email',
            'new_managers.*.permission_level' => 'nullable|in:owner,manager,worker',
        ]);

        $business->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        if ($request->has('services')) {
            foreach ($request->services as $serviceData) {
                if (!empty($serviceData['id'])) {
                    $service = \App\Models\Service::find($serviceData['id']);
                    if ($service && $service->business_id == $business->id) {
                        $service->update([
                            'name' => $serviceData['name'],
                            'description' => $serviceData['description'] ?? null,
                            'duration_minutes' => $serviceData['duration_minutes'],
                            'price' => $serviceData['price'],
                        ]);
                    }
                } else {
                    $business->services()->create([
                        'name' => $serviceData['name'],
                        'description' => $serviceData['description'] ?? null,
                        'duration_minutes' => $serviceData['duration_minutes'],
                        'price' => $serviceData['price'],
                    ]);
                }
            }
        }

        collect($validated['managers'] ?? [])->each(function (array $m) use ($business) {
            $bm = $business->business_managers()->find($m['id']);
            if (! $bm) return;

            if (! empty($m['delete']) && $m['delete'] == '1') {
                $bm->delete();
            } else {
                $bm->update(['permission_level' => $m['permission_level']]);
            }
        });

        $errors = [];
        foreach ($validated['new_managers'] ?? [] as $nm) {
            if (empty($nm['email'])) continue;

            $user = \App\Models\User::where('email', $nm['email'])->first();
            if ($business->business_managers->contains('user_id', $user->id)) {
                $errors[] = "Uživatel {$user->email} je již přiřazen.";
                continue;
            }
            $business->business_managers()->create([
                'user_id'          => $user->id,
                'permission_level' => $nm['permission_level'] ?? 'manager',
            ]);
        }

        if ($errors) {
            return back()->withErrors($errors);
        }

        return redirect()
            ->route('business.show', $business->id)
            ->with('success', 'Firma byla úspěšně upravena.');
    }
}
