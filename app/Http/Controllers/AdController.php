<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller {
    public function index() {
        return view('/ad/index');
    }

    public function showCreateForm() {
        return view('/ad/create');
    }
    public function submitCreateForm(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_day' => 'required',
            'location' => 'required|string|max:255',
            'expires_at' => 'required|date|after:today',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('ads', 'public');
            $validated['photo_path'] = $path;
        }

        Ad::create($validated);

        return redirect('/');
    }
}
