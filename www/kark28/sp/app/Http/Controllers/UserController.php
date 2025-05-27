<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;


class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => ['required',  'regex:/^([A-Za-zÁ-ž]{2,}(-[A-Za-zÁ-ž]{2,})*)( ([A-Za-zÁ-ž]{2,}(-[A-Za-zÁ-ž]{2,})*))*$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],

        ], [
            'name.regex' => 'Jméno může obsahovat pouze písmena, pomlčky a mezery, každé slovo musí mít alespoň 2 znaky.',
            'name.required' => 'Jméno je povinné.',
            'email.required' => 'Email je povinný.',
            'email.email' => 'Email musí být ve formátu example@email.cz',
            'password.required' => 'Heslo je povinné.',
            'password.min' => 'Heslo musí mít alespoň 8 znaků.'
        ]);

        $user = User::create([
            'name' => Str::of($fields['name'])->trim(),
            'email' => Str::of($fields['email'])->trim(),
            'password_hash' => Hash::make($fields['password'])
        ]);

        Auth::login($user);
        return redirect('/');
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Tento email není registrovaný.'])->withInput();
        }

        if (!Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors(['password' => 'Heslo není správné.'])->withInput();
        }

        // Everything OK
        Auth::login($user);
        $owned = $user->ownedBusiness();

        Cookie::queue('owned_business_id', $owned->id, 60 * 24 * 7);


        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function showUserProfile()
    {

        $user = Auth::user();

        $reservations = $user->reservations()
            ->with('timeslot.service.business')
            ->get();


        $statusTranslations = [
            'pending' => 'Čeká na schválení',
            'confirmed' => 'Potvrzeno',
            'cancelled' => 'Zrušeno',
            'completed' => 'Dokončeno',
            'rejected' => 'Zamítnuto',
            null => 'Neznámý'
        ];


        $now = now();

        $activeReservations = $reservations->filter(function ($reservation) use ($now) {
            return $reservation->timeslot && $reservation->timeslot->start_time > $now;
        });

        $pastReservations = $reservations->filter(function ($reservation) use ($now) {
            return !$reservation->timeslot || $reservation->timeslot->start_time <= $now;
        });




        return view('user.profile', [
            'user' => $user,
            'activeReservations' => $activeReservations,
            'pastReservations' => $pastReservations,
            'statusTranslations' => $statusTranslations
        ]);
    }
}
