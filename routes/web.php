<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\RentalBidController;
use App\Http\Controllers\SaleBidController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';
require __DIR__.'/companySettings.php';
require __DIR__.'/public.php';
require __DIR__.'/ads.php';


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


























//Route::get("/", function () {
//    return view('home/index');
//});

Route::get('/agenda', function () {
    return view('agenda/index');
});

Route::get('/favorites', function () {
    return view('favorites/index');
});

Route::get('/history', function () {
    return view('history/index');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index');
});
