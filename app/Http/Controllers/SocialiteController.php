<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider) // Implement proper redirect to oauth provider
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleCallback($provider) // Will handle successful authentication
    {
        try {
            // Field iz User tabele koje treba da bude update
            $field = null;

            // U zavisnosti da li je Google ili Fcebook
            if ($provider === 'google') {
                $field = 'google_id';
            } elseif($provider === 'facebook') {
                $field = 'facebook_id';
            }

            // dobijamo informacije User-a iz FB ili Googl-a
            $user = Socialite::driver($provider)->stateless()->user();

            // na osnovu email-a selektujemo Usera iz baze podataka
            $dbUser = User::where('email', $user->email)->first();
            // I ako vec postoji User u db, radimo update facebook_id kolone ili google_id kolone
            if ($dbUser) {
                $dbUser->$field = $user->id;
                $dbUser->save();
            } else {
                // A ako ne postoji uopste, kreiramo User-a
                $dbUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    $field => $user->id, //Fb ili Google id
                    'email_verified_at' => now()
                ]);
            }
            // Markujemo User-a da je prosao autentikaciju i logujemo
            Auth::login($dbUser);

            return redirect()->intended(route('home'));

        } catch( \Exception $e) {
            return redirect(route('login'))
                ->with('error', $e->getMessage() ?: 'Something went wrong');
        }
    }
}
