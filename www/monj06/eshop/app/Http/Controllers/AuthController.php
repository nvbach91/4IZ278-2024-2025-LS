<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Category;

class AuthController extends Controller
{
    public function showRegister()
    {
        $categories = Category::all();
        return view('auth.register', [
            'categories' => $categories,
        ]);
    }
    public function showLogin()
    {
        $categories = Category::all();
        return view('auth.login', [
            'categories' => $categories,
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create($validated);
        Auth::login($user);
        return redirect()->route('index');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();

            return redirect()->route('index');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Sorry incorrect credentials'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        //odtrění dat v session
        $request->session()->invalidate();
        //novy csrf token pro session (stare formulare se starym csrf tokenem budou odmitnute)
        $request->session()->regenerateToken();

        return redirect()->route('show.login');
    }
}
