<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Mail\StudentLogin;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Resend;


class StudentAuthController extends Controller
{
    /* ============ REGISTRACE ============ */

    public function showRegister()
    {
        return view('student.auth.register');
    }

    public function register(Request $request)
{
    $data = $request->validate([
        'name'       => ['required', 'string', 'max:255'],
        'email'      => ['required', 'email', Rule::unique((new Student)->getTable())],
        'birth_year' => ['required', 'integer', 'digits:4', 'between:1900,'.date('Y')],
        'password'   => ['required','confirmed', Password::min(8)->letters()->numbers()],
    ]);

    $student = Student::create([
        'name'            => $data['name'],
        'email'           => $data['email'],
        'birth_year'      => $data['birth_year'],
        'password'        => Hash::make($data['password']),
        // výchozí obrázek
        'profile_picture' => 'https://www.pngkit.com/png/detail/126-1262807_instagram-default-profile-picture-png.png',
    ]);

    try {
        Mail::to($request->user())->send(new StudentLogin($student));
    } catch (\Throwable $e) {
        Log::error('Failed to send registration email: ' . $e->getMessage());
    }

    Auth::guard('student')->login($student);

    return redirect()
        ->route('student.dashboard')
        ->with('success', 'Vítej! Tvůj účet byl úspěšně vytvořen.');
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // najdi nebo vytvoř studenta
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


    /* ============ LOGIN ============ */
    public function login(Request $request)
    {
        $cred = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('student')->attempt($cred, $request->boolean('remember'))) {

            $request->session()->regenerate();

            /* zelený banner po úspěchu */
            return redirect()
                   ->route('student.dashboard')
                   ->with('success', 'Přihlášení proběhlo v pořádku.');
        }

        /* červený banner pro špatné údaje */
        return back()
               ->withInput()
               ->with('error', 'Neplatné přihlašovací údaje.');
    }

    /* ============ LOGOUT ============ */
    public function logout(Request $request)
    {
        // odhlášení guardu
        Auth::guard('student')->logout();

        // zneplatnit session kvůli ochraně
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // pak domů s bannerem
        return redirect('/')
               ->with('success', 'Byl(a) jsi úspěšně odhlášen(a).');
    }

    public function dashboard()
{
    $courses = auth('student')->user()?->courses()->get() ?? collect();

    return view('student.dashboard', compact('courses'));
}

    public function destroy(Request $request)
    {
        $student = $request->user('student');

        // nejdřív odhlásit studenta a zneplatnit session
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // pak smazat záznam
        $student->delete();

        return redirect('/')
            ->with('success', 'Tvůj účet byl smazán.');
    }

}
