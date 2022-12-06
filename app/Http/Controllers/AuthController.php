<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        else{
            return redirect()->intended('home');
        }

    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('dashboard');
    }

    public function register(Request $request)
    {

    }

    public function update(Request $request)
    {

    }
}
