<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Company;
use App\Models\SaleBid;
use Illuminate\Http\Request;

class SaleBidController extends Controller
{
    public function create(Advertisement $ad)
    {
        if (!$ad->isSale()) abort(404);

        $ad = $ad->load('sale');
        $company = Company::find($ad->company_id);

        return view('user.createSaleBid', compact('ad', 'company'));
    }

    public function store(Request $request, Advertisement $ad)
    {
        if (!$ad->isSale()) abort(404);

        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        SaleBid::create([
            'advertisement_id' => $ad->id,
            'user_id' => auth()->id(),
            'price' => $request->price,
        ]);

        return redirect()->route('ads.show', ['adId' => $ad->id]);
    }
}
