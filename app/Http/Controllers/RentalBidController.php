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

        $rentalBid = RentalBid::findOrFail($rentalBidId);
        $rentalBid->update([
            'photo_returned' => $path,
        ]);

        $ad = $rentalBid->advertisement()->with('rental')->first();
        if ($ad && $ad->rental) {
            $days = 0;
            if ($rentalBid->start_date && $rentalBid->end_date) {
                $days = max(0, (new \DateTime($rentalBid->start_date))->diff(new \DateTime($rentalBid->end_date))->days);
            }
            $wearPerDay = RentalBid::$WEAR_PER_DAY;
            $increment = $days * max(0, $wearPerDay);
            $newWear = min(100, max(0, (int) $ad->rental->wear_level + $increment));
            $ad->rental->update(['wear_level' => $newWear]);
        }

        return redirect()->back();
    }
}
