<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
            'password' => ['required', 'confirmed'], // password_confirmation
            'user_type' => ['required']
        ]);
        $user = User::create($validatedAttributes);
        Auth::login($user);

        if ($validatedAttributes['user_type'] == 'company') {
            $this->makeNewCompany($user);
        }

        return redirect('/');
    }

    private function makeNewCompany(User $user) {
        $company = Company::create([
            'name' => 'Nieuwe Company',
            'slug' => 'company-' . Str::random(10),
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'logo_url' => null,
            'font_family' => 'Arial, sans-serif',
        ]);

        $user['company_id'] = $company->id;
        $company->save();
        $user->save();
    }
}
