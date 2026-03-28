<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\Rental;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdController extends Controller {
    public function showAd($adId): View {
        $ad = Advertisement::where('id', $adId)->first();

        $company = $ad->company;

        return view('public.ad', compact('company', 'ad'));
    }

    public function showCreateAd($companySlug = null): View {
        if (auth()->user()->user_type == User::TYPE_COMPANY) {
            $company = auth()->user()->company;
        } else {
            $company = Company::getBySlug($companySlug);
        }

        return view('seller.createAd', compact('company'));
    }

    public function createAd(Request $request, string $companySlug = null)
    {
        if (auth()->user()->user_type == User::TYPE_COMPANY) {
            $company = auth()->user()->company;
        } else {
            $company = Company::getBySlug($companySlug);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:sale,rental',
            'company_id' => 'exists:companies,id',
        ]);

        $ad = Advertisement::create([
            'title' => $request->title,
            'description' => $request->description,
            'company_id' => $company->id,
            'type' => $request->type,
            'user_id' => auth()->id(),
        ]);

        switch ($request->type) {
            case 'sale':
                return $this->createSale($request, $ad);
            case 'rental':
                return $this->createRental($request, $ad);
        }

        abort(404);
    }

    private function createSale(Request $request, Advertisement $ad)
    {
        $request->validate([
            'start_price' => 'required|numeric|min:0',
            'end_time' => 'required|date|after:now',
            'max_bids' => 'nullable|integer|min:1|max:4',
        ]);

        Sale::create([
            'advertisement_id' => $ad->id,
            'start_price' => $request->start_price,
            'end_time' => $request->end_time,
            'max_bids' => $request->max_bids ?? 4,
        ]);

        return redirect()->back()->with('success', 'Sale created!');
    }
    private function createRental(Request $request, Advertisement $ad)
    {
        $request->validate([
            'rental_price' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'max_rentals' => 'nullable|integer|min:1|max:4',
        ]);

        Rental::create([
            'advertisement_id' => $ad->id,
            'price_per_day' => $request->rental_price,
            'deposit' => $request->deposit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'max_rentals' => $request->max_rentals ?? 4,
        ]);

        return redirect()->back()->with('success', 'Rental created!');
    }
}
