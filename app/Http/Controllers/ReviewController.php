<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function reviewProfile(Request $request, User $user): RedirectResponse {
        $validated = $request->validate([
            'rating' => 'string',
            'comment' => 'nullable|string'
        ]);

        if (!($senderUser = auth()->user())) {
            abort(403);
        }

        Review::create([
            'user_sender_id' => $senderUser->id,
            'user_id' => $user->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);


        return redirect()->back();

    }

    public function reviewAd(Request $request, $adId) {
        $validated = $request->validate([
            'rating' => 'string',
            'comment' => 'nullable|string'
        ]);

        if (!($user = auth()->user())) {
            abort(403);
        }

        Review::create([
            'user_sender_id' => $user->id,
            'advertisement_id' => $adId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->back();
    }
}
