<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function showRegisterForm() {
            return view('auth.register');
        }

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => ['required',  'regex:/^([A-Za-zÁ-ž]{2,}(-[A-Za-zÁ-ž]{2,})*)( ([A-Za-zÁ-ž]{2,}(-[A-Za-zÁ-ž]{2,})*))*$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],

        ], ['name.regex' => 'Jméno může obsahovat pouze písmena, pomlčky a mezery, každé slovo musí mít alespoň 2 znaky.',       
        'name.required' => 'Jméno je povinné.',
        'email.required' => 'Email je povinný.',
        'email.email' => 'Email musí být ve formátu example@email.cz',
        'password.required' => 'Heslo je povinné.',
        'password.min' => 'Heslo musí mít alespoň 8 znaků.']);

        $user = User::create([
            'name' => Str::trim($fields['name']),
            'email' => Str::trim($fields['email']),
            'password_hash' => Hash::make($fields['password'])
        ]);

        Session::put('user_id', $user->id);
        Session::put('username', $user->name);
        return redirect('/');
    }

    public function login(Request $request) {
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
        Session::put('user_id', $user->id);
        Session::put('username', $user->name);

        return redirect('/');
    }

    public function logout() {
        Session::forget('user_id');
        return redirect('/');
    }

    public function showUserProfile() {
        return view('user.profile');
    }

}
