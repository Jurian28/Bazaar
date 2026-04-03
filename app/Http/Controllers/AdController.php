<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\Rental;
use App\Models\Review;
use App\Models\Sale;
use App\Models\User;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class AdController extends Controller {
    public function ads(Request $request, $companySlug = null): View {
        $company = Company::getBySlug($companySlug);

        $adsQuery = $company->advertisements()->with(['sale', 'rental']);
        $ads = $this->getAdsWithFilter($adsQuery, $request);


        return view('public.ads', compact('company', 'ads'));
    }

    public function showAd(Request $request, $adId): View {
        $ad = Advertisement::where('id', $adId)->first();

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
        $qrCode = new Builder(
            writer: new PngWriter(),
            data: route('ads.show', ['adId' => $adId])
        );

        return $qrCode->build()->getDataUri();
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
                $this->createSale($request, $ad);
                break;
            case 'rental':
                $this->createRental($request, $ad);
                break;
        }
        return $this->ads($companySlug);
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
    }
    private function createRental(Request $request, Advertisement $ad)
    {
        $request->validate([
            'price_per_day' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'max_rentals' => 'nullable|integer|min:1|max:4',
        ]);

        Rental::create([
            'advertisement_id' => $ad->id,
            'price_per_day' => $request->price_per_day,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'max_rentals' => $request->max_rentals ?? 4,
        ]);
    }


    public function review(Request $request, $adId) {
        $validated = $request->validate([
            'rating' => 'string',
            'comment' => 'nullable|string'
        ]);

        if (!($user = auth()->user())) {
            abort(403);
        }

        Review::create([
            'user_id' => $user->id,
            'advertisement_id' => $adId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->back();
    }

    public function getAdsWithFilter($AdSstartQuery, Request $request) {
        $query = $AdSstartQuery;

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
        $ads = $query->paginate(10)->withQueryString();

        return $ads;
    }


    public function uploadAds(Request $request): void
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ], [
            'csv_file.required' => 'The CSV file is required.',
            'csv_file.mimes' => 'The CSV file must be a file of type: csv, txt.'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $header = array_shift($data);
        foreach ($data as $row) {
            $row = array_combine($header, $row);
            Advertisement::create([
                'title' => $row['title'],
                'description' => $row['description'],
                'price' => $row['price'],
                'image' => $row['image'],
                'type' => $row['type'],
                'user_id' => auth()->id(),
                'expires_at' => $row['expires_at'],
            ]);
        }
    }

}
