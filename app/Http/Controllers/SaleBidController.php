<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\SaleBid;
use Illuminate\Http\Request;

class SaleBidController extends Controller
{
    public function store(Request $request, Advertisement $ad)
    {
        if (!$ad->isSale()) abort(404);

        SaleBid::create([
            'advertisement_id' => $ad->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('ads.show', ['adId' => $ad->id]);
    }
}
