<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index($companySlug = null): View
    {
        $company = Company::getBySlug($companySlug);
        $components = $company->components()->orderBy('order', 'desc')->get();
        return view('public.index', compact('company', 'components'));
    }

    public function ads($companySlug = null): View {
        $company = Company::getBySlug($companySlug);
        $ads = $company->advertisements()->with('user')->get();

        return view('public.ads', compact('company', 'ads'));
    }
}
