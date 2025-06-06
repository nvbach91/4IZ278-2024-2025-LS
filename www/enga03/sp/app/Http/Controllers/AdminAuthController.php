<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($data, $request->boolean('remember'))){
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard')
                ->with('success', 'Admin is logged in.');
        }

        return back()->withInput()
            ->with('error', 'Invalid admin credentials.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'You have been logged out as admin.');
    }
}
