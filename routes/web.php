<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\RentalBidController;
use App\Http\Controllers\SaleBidController;
use Illuminate\Support\Facades\Route;
require __DIR__ . '/routes/auth.php';
require __DIR__ . '/routes/companySettings.php';
require __DIR__ . '/routes/public.php';
require __DIR__ . '/routes/ads.php';
require __DIR__ . '/routes/history.php';
require __DIR__ . '/routes/favorites.php';


Route::get('/ads/{adId}', [AdController::class, 'showAd'])->name('ads.show');

Route::get('/ads/{ad}/rent', [RentalBidController::class, 'create'])->name('ads.rent.form');
Route::post('/ads/{ad}/rent', [RentalBidController::class, 'store'])->name('ads.rent');

Route::get('/ads/{ad}/bid', [SaleBidController::class, 'create'])->name('ads.bid.form');
Route::post('/ads/{ad}/bid', [SaleBidController::class, 'store'])->name('ads.bid');

getAdsRoutes(NO_SLUG_ROUTE_SUFFIX);
getAuthRoutes(NO_SLUG_ROUTE_SUFFIX);
getPublicRoutes(NO_SLUG_ROUTE_SUFFIX);

Route::prefix('c/{companySlug}')->group(function () {
    getAdsRoutes();
    getAuthRoutes();
    getPublicRoutes();
});
