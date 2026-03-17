<?php

namespace App\Http\Controllers;

use App\Models\Company;

class PublicController extends Controller
{
    public function index($companySlug) {
        $company = Company::where('slug', $companySlug)->first();

        return view('user.index', ['company' => $company]);

    }
}
