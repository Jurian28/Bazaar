<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\OfferBid;
use Illuminate\Http\Request;

class OfferBidController extends Controller
{
    public function create(Advertisement $ad)
    {
        if (!$ad->isOffer()) abort(404);

       $ad = $ad->load('offer');
        $company = Company::find($ad->company_id);

        return view('user.createOfferBid', compact('ad', 'company'));
    }

    public function store(Request $request, Advertisement $ad)
    {
        if (!$ad->isOffer()) abort(404);

        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $userId = auth()->id();
        // Maximum 4 bids per user overall
        $totalBids = OfferBid::where('user_id', $userId)->count();
        if ($totalBids >= Advertisement::MAXIMUM) {
            return redirect()->back()->withErrors(['price' => __('You have reached the maximum number of bids (4).')]);
        }
        // Maximum 4 bids per user on a single advertisement
        $perAdBids = OfferBid::where('user_id', $userId)->where('advertisement_id', $ad->id)->count();
        if ($perAdBids >= Advertisement::MAXIMUM) {
            return redirect()->back()->withErrors(['price' => __('You have reached the maximum number of bids on this advertisement (4).')]);
        }

        OfferBid::create([
            'advertisement_id' => $ad->id,
            'user_id' => $userId,
            'price' => $request->price,
        ]);

        return redirect()->route('ads.show', ['adId' => $ad->id]);
    }

    public function acceptOfferBid($offerBidId) {
        OfferBid::find($offerBidId)->update([
            'accepted' => true,
        ]);
        return redirect()->back();
    }
}
