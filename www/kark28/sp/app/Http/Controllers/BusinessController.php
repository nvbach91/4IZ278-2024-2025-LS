<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function home()
{
    $businesses = Business::with(['business_managers.user', 'reviews'])->paginate(12);
    return view('home', compact('businesses'));
}


    public function show($id) {
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

    public function create() {
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

        $business=Business::create($validated); 

        
        BusinessManager::create([
        'business_id' => $business->id,
        'user_id' => $user->id,
        'permission_level' => 'owner',
        ]);

        return redirect()->route('business.show', $business->id)->with('success', 'Business byl úspěšně vytvořen!');

    }
}

