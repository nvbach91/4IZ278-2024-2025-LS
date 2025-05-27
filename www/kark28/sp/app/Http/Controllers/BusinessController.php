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
            'services',
            'business_managers' => function ($query) {
                $query->orderByRaw("FIELD(permission_level, 'owner', 'manager', 'worker')");
            },
            'business_managers.user',
            'reviews.user'
        ])->findOrFail($id);

        return view('business.show', compact('business'));
    }

    public function create()
    {
        $user = Auth::user();


        $alreadyManager = BusinessManager::where('user_id', $user->id)->exists();

        if ($alreadyManager) {

            $businessId = BusinessManager::where('user_id', $user->id)->value('business_id');

            return redirect()->route('business.show', $businessId)->with('error', 'Už spravujete jeden business.');
        }

        return view('business.create');
    }


    public function store(Request $request)
    {

        $user = Auth::user();

        $ownedBusiness = $user->ownedBusiness();
        if ($ownedBusiness) {
            return redirect()->route('business.show', $ownedBusiness->id)
                ->with('error', 'Už vlastníte jeden business.');
        }


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $business = Business::create($validated);


        BusinessManager::create([
            'business_id' => $business->id,
            'user_id' => $user->id,
            'permission_level' => 'owner',
        ]);


        return redirect()->route('business.show', $business->id)->with('success', 'Business byl úspěšně vytvořen!');
    }

    public function edit($id)
    {
        $business = Business::with([
            'services',
            'business_managers.user'
        ])->findOrFail($id);


        $userId = Auth::id();

        $manager = BusinessManager::where('business_id', $business->id)
            ->where('user_id', $userId)
            ->whereIn('permission_level', ['owner', 'manager'])
            ->first();

        if (!$manager) {
            abort(403, 'Nemáte oprávnění upravovat tento byznys.');
        } else
            $roles = BusinessManager::availableRoles();

        return view('business.edit', compact('business', 'roles'));
    }


    public function update(Request $request, $id)
    {
        $business = Business::findOrFail($id);

        // Validace základních údajů o firmě
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ];

        // Pokud jsou odeslány služby, validuj i je
        if ($request->has('services')) {
            $rules['services.*.id'] = 'nullable|integer|exists:services,id';
            $rules['services.*.name'] = 'required|string|max:255';
            $rules['services.*.description'] = 'nullable|string';
            $rules['services.*.duration_minutes'] = 'required|integer|min:1';
            $rules['services.*.price'] = 'required|numeric|min:0';
        }

        $validated = $request->validate($rules);

        // Aktualizace firmy
        $business->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        // Pokud jsou odeslány služby, aktualizuj je
        if ($request->has('services')) {
            foreach ($request->services as $serviceData) {
                if (!empty($serviceData['id'])) {
                    // Aktualizace existující služby
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
                    // Vytvoření nové služby
                    $business->services()->create([
                        'name' => $serviceData['name'],
                        'description' => $serviceData['description'] ?? null,
                        'duration_minutes' => $serviceData['duration_minutes'],
                        'price' => $serviceData['price'],
                    ]);
                }
            }
        }

        // Odebrat manažery
        if ($request->has('managers')) {
            foreach ($request->input('managers') as $managerData) {
                if (!empty($managerData['delete']) && $managerData['delete'] == '1') {
                    $managerRecord = BusinessManager::find($managerData['id']);
                    if ($managerRecord && $managerRecord->business_id == $business->id) {
                        $managerRecord->delete();
                    }
                }
            }
        }


        // Přidat nového podle e-mailů
        $errors = [];

        if ($request->has('new_managers')) {
            foreach ($request->input('new_managers') as $newManagerData) {
                if (!empty($newManagerData['email'])) {
                    $user = \App\Models\User::where('email', $newManagerData['email'])->first();

                    if (!$user) {
                        // Uživatel nenalezen
                        $errors[] = "Uživatel s e-mailem {$newManagerData['email']} nebyl nalezen.";
                        continue;
                    }

                    $alreadyAssigned = $business->business_managers->contains('user_id', $user->id);

                    if ($alreadyAssigned) {
                        $errors[] = "Uživatel {$user->email} je již přiřazen.";
                        continue;
                    }

                    $role = $newManagerData['permission_level'] ?? 'manager';

                    BusinessManager::create([
                        'business_id' => $business->id,
                        'user_id' => $user->id,
                        'permission_level' => $role,
                    ]);
                }
            }
        }

        if (!empty($errors)) {
            return back()->withErrors($errors);
        }



        return redirect()->route('business.show', $business->id)->with('success', 'Firma byla úspěšně upravena.');
    }
}
