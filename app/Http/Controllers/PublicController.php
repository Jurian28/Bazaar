<?php

namespace App\Http\Controllers;

use App\Models\Company;

class PublicController extends Controller
{
    public function index($companySlug = null) {
        $company = Company::getBySlug($companySlug);

        return view('public.index', ['company' => $company]);
    }
}
