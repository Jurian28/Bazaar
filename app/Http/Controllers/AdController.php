<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Rental;
use App\Models\Sale;
use App\Models\User;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdController extends Controller {
    public function ads(Request $request, $companySlug = null): View {
        $company = Company::getBySlug($companySlug);

        $adsQuery = $company->advertisements()->with(['sale', 'rental', 'offer', 'company', 'user']);
        $ads = $this->getAdsWithFilter($adsQuery, $request);


        return view('public.ads', compact('company', 'ads'));
    }

    public function showAd(Request $request, $adId): View {
        $ad = Advertisement::with('offerBids')->findOrFail($adId);

        $qrCode = $this->getQrCode($adId);

        $company = $ad->company;

        $query = $ad->reviews()->latest();

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate(5)->withQueryString();

        return view('public.ad', compact('company', 'ad', 'reviews', 'qrCode'));
    }

    private function getQrCode($adId): string {
        // Build QR code data URI using Endroid QrCode v6 fluent builder
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data(route('ads.show', ['adId' => $adId]))
            ->build();

        return $result->getDataUri();
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
            'type' => 'required|in:sale,offer,rental',
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
                $this->createSale($request, $ad);
                break;

            case 'offer':
                $this->createOffer($request, $ad);
                break;

            case 'rental':
                $this->createRental($request, $ad);
                break;
        }

        return $this->ads($request, $companySlug);
    }

    private function createSale(Request $request, Advertisement $ad)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        Sale::create([
            'advertisement_id' => $ad->id,
            'price' => $request->price,
        ]);
    }

    private function createRental(Request $request, Advertisement $ad)
    {
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
    }

    private function createOffer(Request $request, Advertisement $ad)
    {
        $request->validate([
            'start_price' => 'required|numeric|min:0',
            'offer_end_date' => 'required|date|after_or_equal:today',
        ]);

        Offer::create([
            'advertisement_id' => $ad->id,
            'start_price' => $request->start_price,
            'end_date' => $request->offer_end_date,
        ]);
    }

    public function getAdsWithFilter($AdSstartQuery, Request $request) {
        $query = $AdSstartQuery;

        $query->when($request->filled('type'), function ($q) use ($request) {
            $q->where('type', $request->type);
        });
        $query->when($request->filled('min_price'), function ($q) use ($request) {
            $q->whereHas('sale', function ($q2) use ($request) {
                $q2->where('price', '>=', $request->min_price);
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
        $ads = $query->paginate(10)->withQueryString();

        return $ads;
    }



    public function uploadAds(Request $request, $companyId) {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $header = array_shift($data);

        DB::transaction(function() use ($data, $header, $companyId) {
            foreach ($data as $row) {
                $row = array_combine($header, $row);

                $ad = Advertisement::create([
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'type' => $row['type'],
                    'user_id' => auth()->id(),
                    'company_id' => $companyId
                ]);

                switch ($row['type']) {
                    case 'rental':
                        Rental::create([
                            'advertisement_id' => $ad->id,
                            'start_date' => $row['start_date'],
                            'end_date' => $row['end_date'],
                            'price_per_day' => $row['price_per_day'],
                        ]);
                        break;

                    case 'sale':
                        Sale::create([
                            'advertisement_id' => $ad->id,
                            'price' => $row['price'],
                        ]);
                        break;

                    case 'offer':
                        Offer::create([
                            'advertisement_id' => $ad->id,
                            'start_price' => $row['start_price'],
                            'end_date' => $row['end_date_offer'],
                        ]);
                        break;
                }
            }
        });

        return redirect()->back()->with('success', 'CSV uploaded successfully!');
    }
}
