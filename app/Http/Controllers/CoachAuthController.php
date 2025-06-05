<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachAuthController extends Controller
{
    /** Zpracuje POST /coach/login */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('coach')->attempt($data, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()
                ->intended('/coach/dashboard')
                ->with('success', 'Kouč je přihlášen.');
        }

        return back()
            ->withInput()
            ->with('error', 'Neplatné přihlašovací údaje pro kouče.');
    }

    /** Zpracuje POST /coach/logout */
    public function logout(Request $request)
    {
        Auth::guard('coach')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Byl jsi odhlášen jako kouč.');
    }

    /** Zobrazí view coach.dashboard */
    public function dashboard()
    {
        return view('coach.dashboard');
    }
}
