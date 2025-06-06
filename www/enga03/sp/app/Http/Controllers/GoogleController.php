<?php
// Controller pro Google OAuth

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            Log::info('Google user details:', ['user' => $googleUser]);
        } catch (\Exception $e) {
            Log::error('Error during Google callback: ' . $e->getMessage());
            return redirect()->route('student.login.show')->withErrors('Something went wrong during Google authentication.');
        }

        $student = Student::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'            => $googleUser->getName(),
                'oauth_provider'  => 'google',
                'profile_picture' => $googleUser->getAvatar(),
            ]
        );

        Log::info('Student created/logged in:', ['student' => $student]);

        Auth::guard('student')->login($student);

        return redirect()->route('student.dashboard');
    }
}
