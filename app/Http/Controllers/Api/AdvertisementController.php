<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Rental;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdvertisementController extends Controller
{
    public function index(Request $request, $companySlug = null)
    {
        $company = Company::getBySlug($companySlug);
        $adsQuery = $company->advertisements()->with(['sale', 'rental']);
        $ads = $this->applyFilters($adsQuery, $request);
        return response()->json($ads);
    }

    public function show($id)
    {
        $ad = Advertisement::with([
            'sale', 'rental', 'offer',
            'saleBids', 'rentalBids', 'offerBids',
            'user', 'company', 'reviews'
        ])->findOrFail($id);

        return response()->json($ad);
    }

    public function store(Request $request, $companySlug = null)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        $authUser = auth()->user();

        if (!in_array($authUser->user_type, [User::TYPE_SELLER, User::TYPE_COMPANY])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($authUser->user_type == User::TYPE_COMPANY) {
            $company = $authUser->company;
        } else {
            $company = Company::getBySlug($companySlug);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:sale,offer,rental',
            // sale
            'price' => 'nullable|numeric|min:0',
            // rental
            'price_per_day' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date|after_or_equal:today',
            'rental_end_date' => 'nullable|date|after:start_date',
            // offer
            'start_price' => 'nullable|numeric|min:0',
            'offer_end_date' => 'nullable|date|after_or_equal:today',
        ]);

        $ad = Advertisement::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'company_id' => $company->id,
            'type' => $data['type'],
            'user_id' => $authUser->id,
        ]);

        switch ($data['type']) {
            case 'sale':
                $request->validate(['price' => 'required|numeric|min:0']);
                Sale::create([
                    'advertisement_id' => $ad->id,
                    'price' => $request->price,
                ]);
                break;
            case 'rental':
                $request->validate([
                    'price_per_day' => 'required|numeric|min:0',
                    'start_date' => 'nullable|date|after_or_equal:today',
                    'rental_end_date' => 'nullable|date|after:start_date',
                ]);
                Rental::create([
                    'advertisement_id' => $ad->id,
                    'price_per_day' => $request->price_per_day,
                    'start_date' => $request->start_date,
                    'end_date' => $request->rental_end_date,
                ]);
                break;
            case 'offer':
                $request->validate([
                    'start_price' => 'required|numeric|min:0',
                    'offer_end_date' => 'required|date|after_or_equal:today',
                ]);
                Offer::create([
                    'advertisement_id' => $ad->id,
                    'start_price' => $request->start_price,
                    'end_date' => $request->offer_end_date,
                ]);
                break;
        }

        return response()->json($ad->load(['sale','rental','offer']), 201);
    }

    private function applyFilters($query, Request $request)
    {
        $query->when($request->filled('type'), function ($q) use ($request) {
            $q->where('type', $request->type);
        });
        $query->when($request->filled('min_price'), function ($q) use ($request) {
            $q->whereHas('sale', function ($q2) use ($request) {
                $q2->where('start_price', '>=', $request->min_price);
            });
        });
        $query->when($request->filled('max_bids'), function ($q) use ($request) {
            $q->whereHas('sale', function ($q2) use ($request) {
                $q2->where('max_bids', '<=', $request->max_bids);
            });
        });
        $query->when($request->filled('price_per_day'), function ($q) use ($request) {
            $q->whereHas('rental', function ($q2) use ($request) {
                $q2->where('price_per_day', '<=', $request->price_per_day);
            });
        });
        $query->when($request->filled('wear_level'), function ($q) use ($request) {
            $q->whereHas('rental', function ($q2) use ($request) {
                $q2->where('wear_level', $request->wear_level);
            });
        });
        $query->when($request->filled('search'), function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%');
        });

        return $query->paginate(10)->withQueryString();
    }
}
