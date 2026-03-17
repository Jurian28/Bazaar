<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store() {
        $validatedAttributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(!Auth::attempt($validatedAttributes)) {
            throw ValidationException::withMessages([
                'email' => 'email verkeerd'
            ]);
        }

        request()->session()->regenerate();

        return redirect('/');
    }

    public function destroy() {
        Auth::logout();

        return redirect('/');
    }
}
