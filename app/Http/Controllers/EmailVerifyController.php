<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill(); //EmailVerificationRequest klasa ima property $request a on metodu fulfill()

        return redirect()->route('home')
            ->with('success', 'Your Email was verified!');
    }

    public function notice()
    {
        return view('auth.verify-email');
    }

    public function send(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent');
    }
}
