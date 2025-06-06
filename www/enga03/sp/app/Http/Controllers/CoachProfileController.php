<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\Coach;

class CoachProfileController extends Controller
{
    /** Zobrazí profil přihlášeného kouče */
    public function show(Request $request)
    {
        $coach = $request->user('coach');
        return view('coach.profile', compact('coach'));
    }

    /** Uloží změny profilu kouče */
    public function update(Request $request)
    {
        $coach = $request->user('coach');

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email',
                           Rule::unique('z_coaches')->ignore($coach->id)],
            'profile_picture' => ['nullable', 'url', 'max:255'],
            'password' => ['nullable', 'confirmed',
                           Password::min(8)->letters()->numbers()],
        ]);

        $coach->fill([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        if (!empty($data['profile_picture'])) {
            $coach->profile_picture = $data['profile_picture'];
        }

        if ($request->filled('password')) {
            $coach->password = Hash::make($data['password']);
        }

        $coach->save();

        return back()->with('success', 'Profil kouče byl úspěšně aktualizován.');
    }
}
