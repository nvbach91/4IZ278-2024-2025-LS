<?php
// Controller pro Google OAuth

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;


class GoogleController extends Controller
{
    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $student = Student::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'            => $googleUser->getName(),
                'oauth_provider'  => 'google',
                'profile_picture' => $googleUser->getAvatar(),
            ]
        );

        Auth::guard('student')->login($student);

        return redirect()->route('student.dashboard');
    }
}
