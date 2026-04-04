<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm($companySlug = null): View {
        $company = Company::getBySlug($companySlug);

        return view('auth.login', compact('company'));
    }
    public function login(): RedirectResponse
    {
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

        return redirect(company_route('index'));
    }
    public function logout() {
        Auth::logout();

        return redirect('/'); // TODO: fix
    }

    public function showRegisterForm($companySlug = null) {
        $company = Company::getBySlug($companySlug);
        return view('auth.register', compact('company'));
    }
    public function register() {
        $validatedAttributes = request()->validate([ 'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'], // password_confirmation
            'user_type' => ['required']
        ]);
        $user = User::create($validatedAttributes);
        Auth::login($user);

        if ($validatedAttributes['user_type'] == 'company') {
            $company = $this->makeNewCompany($user);
            $user->company_id = $company->id;
            $user->save();
        }

        return redirect(company_route("index"));
    }

    private function routeBasedOnRole() {
        $user = Auth::user();

        if (!$user) {
            return abort(404);
        }
        $role = $user->user_type;

        switch ($role) {
            case User::TYPE_COMPANY:
                return redirect('company.showSettings');
                break;
            case User::TYPE_SELLER:
                return redirect('/');
                break;

        }
    }

    private function makeNewCompany($user)
    {
        do {
            $slug = Str::random(10);
        } while (Company::where('slug', $slug)->exists());


        return Company::create([
            'name' => 'New Company',
            'slug' => $slug,
            'primary_color' => '#1F2937',
            'secondary_color' => '#6B7280',
            'font_family' => '',
        ]);
    }
}
