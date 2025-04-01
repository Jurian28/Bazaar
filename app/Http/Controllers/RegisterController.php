<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create() {
        return view('auth.register');
    }

    public function store() {
        $validatedAttributes = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(6), 'confirmed'], // password_confirmation
            'user_type' => ['required']
        ]);

        $user = User::create($validatedAttributes);

        Auth::login($user);

        return redirect('/');
        dd('?');
    }
}
