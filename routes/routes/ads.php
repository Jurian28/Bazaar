<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\RentalBidController;
use App\Http\Controllers\SaleBidController;
use Illuminate\Support\Facades\Route;



Route::get('/ads/{adId}', [AdController::class, 'showAd'])->name('ads.show');
Route::post('/ads/{adId}/review', [AdController::class, 'review'])->name('ads.review');

Route::controller(RentalBidController::class)
    ->middleware(['role:user'])
    ->group(function () {
        Route::get('/ads/{ad}/rent',  'create')->name('ads.rent.form');
        Route::post('/ads/{ad}/rent',  'store')->name('ads.rent');

    });

Route::controller(SaleBidController::class)
    ->middleware(['role:user'])
    ->group(function () {
        Route::get('/ads/{ad}/bid',  'create')->name('ads.bid.form');
        Route::post('/ads/{ad}/bid',  'store')->name('ads.bid');
    });


if (!function_exists('getAdsRoutes')) {
    function getAdsRoutes($suffix = ""): void
    {
        Route::controller(AdController::class)->group(function () use ($suffix) {
            Route::get('/ads', 'ads')->name('ads' . $suffix);
            Route::get('/ad/create', 'showCreateAd')->name('ad.create' . $suffix)->middleware('role:seller,company');
            Route::post('/ad/create', 'createAd')->name('ad.create' . $suffix)->middleware('role:seller,company');
        });
    }
}
