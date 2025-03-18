<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validacija
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);


        // Pokusaj logina na osnovu datih podataka
        if (Auth::attempt($credentials)) {

            $request->session()->regenerate(); // Ako je uspesno

            return redirect()->intended(route('home'))
                ->with('success', 'Welcome Back, '. Auth::user()->name); // Vraca ga na home page ili na drugu stranicu sa koje dolazi
        }

        // Ako nije uspesno vraca ga nazad sa error message i sa e-mail adresom koju je ukucao
        return  redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records'
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->regenerate(); // Regenerate session
        $request->session()->regenerateToken(); // Regenerate CSRF Token

        return redirect()->route('home');
    }
}
