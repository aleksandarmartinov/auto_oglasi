<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]); // vreacamo view sa autentikovanim userom
    }

    public function update(Request $request)
    {
//        $request->validate([
//            'name' => ['required', 'string', 'max:255'],
//            'phone' => ['required', 'string', 'max:255', 'unique:users,phone,' . Auth::id()]
//        ]);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone,'.$request->user()->id]
        ];

        $user = $request->user();

        if (!$user->isOauthUser()) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id];
        }

        $data = $request->validate($rules);

        $user->fill($data); // Update user sa novim podatcima kada je prosla validacija

        $success = 'Your profile was updated'; // Za return

        // Ako se email promenio onda mora i nov zahtev za verifikaciju emaila da se posalje pa email_verified_at field stavljamo null
        // isDirty metoda je ako se nesto promenilo, ovde je to email
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
            $success = 'Email Verification is required, please check your email';
        }

        $user->save();

        return redirect(route('profile.index'))->with('success', $success);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'confirmed',
                Password::min(8)
                    ->max(24)
                    ->numbers()
                    ->mixedCase()
                    ->symbols()
                    ->uncompromised()]
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password) // Hashed password
        ]);

        return back()->with('success', 'Password updated successfully');
    }
}
