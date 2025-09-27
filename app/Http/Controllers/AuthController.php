<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        // $validated = $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required|string'
        // ]);
        
        // if (Auth::attempt($validated)) {
        //     $request->session()->regenerate();

        //     return redirect()->route('dashboard');
        // }
    }

    public function logout(Request $request) {
        Auth::login();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('show.login');
    }
}
