<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if (auth()->check()) {
            return response()->json(['message' => 'Already logged in'], 400);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
            'user_type' => ['nullable', 'in:user,seller,company,admin'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => $data['user_type'] ?? User::TYPE_USER,
        ]);

        Auth::login($user);

        return response()->json([
            'message' => 'Registered successfully',
            'user' => $user->only(['id','name','email','user_type'])
        ], 201);
    }

    public function login(Request $request)
    {
        if (auth()->check()) {
            return response()->json(['message' => 'Already logged in'], 400);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, true)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'Logged in successfully',
            'user' => $user->only(['id','name','email','user_type'])
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me()
    {
        if (!Auth::check()) {
            return response()->json(['user' => null], 200);
        }
        $user = Auth::user();
        return response()->json(['user' => $user->only(['id','name','email','user_type'])]);
    }
}
