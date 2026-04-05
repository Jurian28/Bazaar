<?php

use App\View\Components\Language;
use Illuminate\Support\Facades\Route;
require __DIR__ . '/routes/auth.php';
require __DIR__ . '/routes/companySettings.php';
require __DIR__ . '/routes/public.php';
require __DIR__ . '/routes/ads.php';
require __DIR__ . '/routes/history.php';
require __DIR__ . '/routes/favorites.php';
require __DIR__ . '/routes/contracts.php';


Route::group(['middleware' => 'web'], function () {
    Route::get('change-locale/{locale}', [Language::class, 'changeLocale'])->name('change-locale');
});



getAdsRoutes(NO_SLUG_ROUTE_SUFFIX);
getAuthRoutes(NO_SLUG_ROUTE_SUFFIX);
getPublicRoutes(NO_SLUG_ROUTE_SUFFIX);

Route::prefix('c/{companySlug}')->group(function () {
    getAdsRoutes();
    getAuthRoutes();
    getPublicRoutes();
});
