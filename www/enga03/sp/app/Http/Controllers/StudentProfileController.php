<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    /** Zobrazí profil studenta */
    public function show(Request $request)
    {
        $student = $request->user('student');
        return view('student.profile', compact('student'));
    }

    /** Uloží změny profilu */
    public function update(Request $request)
    {
        $student = $request->user('student');

        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email',
                            Rule::unique('z_students')->ignore($student->id)],
            'birth_year' => ['required', 'integer', 'digits:4', 'between:1900,'.date('Y')],
            'profile_picture' => ['nullable', 'url', 'max:255'],
            'password'   => ['nullable', 'confirmed',
                             Password::min(8)->letters()->numbers()],
        ]);

        $student->fill([
            'name'  => $data['name'],
            'email' => $data['email'],
            'birth_year' => $data['birth_year'],
        ]);

        if (!empty($data['profile_picture'])) {
            $student->profile_picture = $data['profile_picture'];
        }

        if ($request->filled('password')) {
            $student->password = Hash::make($data['password']);
        }

        $student->save();

        return back()->with('success', 'Profil byl úspěšně aktualizován.');
    }

    /** Smaže studentský účet */
    public function destroy(Request $request)
    {
        $student = $request->user('student');

        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $student->delete();

        return redirect('/')->with('success', 'Váš účet byl odstraněn.');
    }
}
