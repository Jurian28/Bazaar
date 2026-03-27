<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\RentalBidController;
use App\Http\Controllers\SaleBidController;
use Illuminate\Support\Facades\Route;



function getAdsRoutes($suffix = ""): void {
    Route::controller(AdController::class)->group(function () use ($suffix) {
        Route::get('/ad/create', 'showCreateAd')->name('ad.create' . $suffix);
        Route::post('/ad/create', 'createAd')->name('ad.create' . $suffix);
    });
}
