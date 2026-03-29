<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyComponent;
use Illuminate\Http\RedirectResponse;
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


    function components() {
        $company = auth()->user()->company;
        $components = $company->components()->orderBy('order', 'desc')->get();
        return view('company.components', compact('company', 'components'));
    }

    function addImage(Request $request)
    {
        $company = auth()->user()->company;

        $validated = $request->validate([
            'image' => ['required', 'image'],
        ]);

        $path = $request->file('image')->store('components', 'public');

        CompanyComponent::create([
            'company_id' => $company->id,
            'type' => 'image',
            'data' => [
                'image' => $path,
            ],
            'order' => CompanyComponent::where('company_id', $company->id)->count() + 1,
        ]);

        return back();
    }

    function addText(Request $request)
    {
        $company = auth()->user()->company;

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'text' => ['required', 'string'],
        ]);

        CompanyComponent::create([
            'company_id' => $company->id,
            'type' => 'text',
            'data' => [
                'title' => $validated['title'] ?? null,
                'text' => $validated['text'],
            ],
            'order' => CompanyComponent::where('company_id', $company->id)->count() + 1,
        ]);

        return back();
    }

    function addAd(Request $request)
    {
        $company = auth()->user()->company;

        $validated = $request->validate([
            'title' => ['nullable', 'string'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);
        CompanyComponent::create([
            'company_id' => $company->id,
            'type' => 'ads',
            'data' => [
                'title' => $validated['title'] ?? 'Recent Ads',
                'limit' => $validated['limit'] ?? 6,
            ],
            'order' => CompanyComponent::where('company_id', $company->id)->count() + 1,
        ]);

        return back();
    }


    public function changeOrder(Request $request, string $direction): RedirectResponse {
        $validated = $request->validate([
            'id' => ['required', 'integer']
        ]);

        $up = $direction === 'up';

        $component = CompanyComponent::findOrFail($validated['id']);

        $switchComponent = CompanyComponent::where('company_id', $component->company_id)
            ->where('order', $up ? '>' : '<', $component->order)
            ->orderBy('order', $up ? 'asc' : 'desc')
            ->first();

        if (!$switchComponent) { // already on top or at the bottom
            return back();
        }

        $tempOrder = $component->order;
        $component->order = $switchComponent->order;
        $switchComponent->order = $tempOrder;

        $component->save();
        $switchComponent->save();

        return back();
    }


    public function delete(Request $request): RedirectResponse {
        $validated = $request->validate([
            'id' => ['required', 'integer']
        ]);

        CompanyComponent::where('id', $validated['id'])->delete();

        return back();
    }
}
