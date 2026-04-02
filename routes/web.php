<?php

use App\View\Components\Header;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
require __DIR__ . '/routes/auth.php';
require __DIR__ . '/routes/companySettings.php';
require __DIR__ . '/routes/public.php';
require __DIR__ . '/routes/ads.php';
require __DIR__ . '/routes/history.php';
require __DIR__ . '/routes/favorites.php';


Route::group(['middleware' => 'web'], function () {
    Route::get('change-locale/{locale}', [Header::class, 'changeLocale'])->name('change-locale');
});


getAdsRoutes(NO_SLUG_ROUTE_SUFFIX);
getAuthRoutes(NO_SLUG_ROUTE_SUFFIX);
getPublicRoutes(NO_SLUG_ROUTE_SUFFIX);

Route::prefix('c/{companySlug}')->group(function () {
    getAdsRoutes();
    getAuthRoutes();
    getPublicRoutes();
});
