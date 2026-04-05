<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller
{
    public function index($companySlug = null): View {
        $company = Company::getBySlug($companySlug);
        $components = $company->components()->orderBy('order', 'desc')->get();
        return view('public.index', compact('company', 'components'));
    }

    public function viewProfile(Request $request, User $user): View {
        $company = Company::getDefaultCompany();
        $query = $user->reviews()->latest();

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate(5)->withQueryString();
        return view('public.profile', compact('user', 'company', 'reviews'));
    }
}
