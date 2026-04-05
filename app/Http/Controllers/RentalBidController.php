<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\RentalBid;
use Illuminate\Http\Request;

class RentalBidController extends Controller
{
    public function create(Advertisement $ad)
    {
        if (!$ad->isRental()) {
            abort(404);
        }

        $company = Company::find($ad->company_id);
        $ad = $ad->load('rental');

        return view('user.createRentalBid', compact('ad', 'company'));
    }

    public function store(Request $request, Advertisement $ad)
    {

        if (!$ad->isRental()) abort(404);

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        RentalBid::create([
            'advertisement_id' => $ad->id,
            'user_id' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('ads.show', ['adId' => $ad->id]);
    }

    public function acceptRentalBid($rentalBidId) {
        RentalBid::find($rentalBidId)->update([
            'accepted' => true,
        ]);
        return redirect()->back();
    }

    public function declineRentalBid($rentalBidId) {
        RentalBid::find($rentalBidId)->update([
            'accepted' => false,
        ]);
        return redirect()->back();
    }


    public function showReturn($rentalBidId) {
        $rentalBid = RentalBid::find($rentalBidId);
        $company = Company::getDefaultCompany();

        return view('user.returnRentalBid', compact('rentalBid', 'company'));
    }


    public function return(Request $request, $rentalBidId) {
        $validated = $request->validate([
            'return_image' => ['required', 'image'],
        ]);
        $path = $request->file('return_image')->store('rentals', 'public');

        $rentalBid = RentalBid::find($rentalBidId)->update([
            'photo_returned' => $path,
        ]);

        return redirect()->back();
    }
}
