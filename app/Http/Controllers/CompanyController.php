<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function showSettings() {
        $company = auth()->user()->company;
        return view('company.settings', compact('company'));
    }

    function updateSettings(Request $request) {
        $company = auth()->user()->company;

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:companies,slug,' . $company->id,
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'logo_url' => 'nullable|url',
            'font_family' => 'nullable|string|max:255',
        ]);

        $company->update($validatedData);

        return redirect()->route('company.showSettings');
    }
}
