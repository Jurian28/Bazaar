<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller {
    public function favorite(Request $request): RedirectResponse {
        $validated = $request->validate([
            'adId' => 'required|integer',
        ]);
        $adId = $validated['adId'];

        $user = auth()->user();
        if ($user->favorites()->where('advertisement_id', $adId)->exists()) {
            $user->favorites()->detach($adId); // unlike
        } else {
            $user->favorites()->attach($adId); // like
        }

        return redirect()->back();
    }


    public function favorites() {
        $user = auth()->user();
        $ads = $user->favorites()->get();
        $company = Company::getDefaultCompany();

        return view('user.favorites', compact('ads', 'company'));
    }
}
