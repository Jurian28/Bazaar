<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\OfferBidController;
use App\Http\Controllers\RentalBidController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SaleBidController;
use Illuminate\Support\Facades\Route;



Route::get('/ads/{adId}', [AdController::class, 'showAd'])->name('ads.show');
Route::post('/ads/{adId}/review', [ReviewController::class, 'reviewAd'])->name('ads.review');

Route::post('/company/{companyId}/uploadAdCSV', [AdController::class, 'uploadAds'])->name('company.uploadAdCSV');

Route::controller(RentalBidController::class)
    ->middleware(['role:user'])
    ->group(function () {
        Route::get('/ads/{ad}/rent',  'create')->name('ads.rent.form');
        Route::post('/ads/{ad}/rent',  'store')->name('ads.rent');

        Route::get('/rentalBid/return/{rentalBidId}',  'showReturn')->name('rental.return.form');
        Route::post('/rentalBid/return/{rentalBidId}',  'return')->name('rental.return');
    });


Route::controller(RentalBidController::class)
    ->middleware(['role:seller,company'])
    ->group(function () {
        Route::get('/rentalBid/accept/{rentalBidId}', 'acceptRentalBid')->name('rentalBid.accept');
        Route::get('/rentalBid/decline/{rentalBidId}', 'declineRentalBid')->name('rentalBid.decline');
    });


Route::controller(SaleBidController::class)
    ->middleware(['role:user'])
    ->group(function () {
        Route::post('/ads/{ad}/buy',  'store')->name('ads.buy');
    });


Route::controller(OfferBidController::class)
    ->middleware(['role:user'])
    ->group(function () {
        Route::get('/ads/{ad}/bid',  'create')->name('ads.bid.form');
        Route::post('/ads/{ad}/bid',  'store')->name('ads.bid');
    });


Route::controller(OfferBidController::class)
    ->middleware(['role:seller,company'])
    ->group(function () {
        Route::get('/offerBid/accept/{offerBidId}', 'acceptOfferBid')->name('offerBid.accept')->middleware('role:seller,company');
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
