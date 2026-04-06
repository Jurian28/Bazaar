<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\AdvertisementController as ApiAdvertisementController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::prefix('v1')->group(function () {

    Route::middleware('web')
        ->withoutMiddleware([VerifyCsrfToken::class])
        ->prefix('auth')
        ->group(function () {
            Route::post('/register', [ApiAuthController::class, 'register']);
            Route::post('/login', [ApiAuthController::class, 'login']);
            Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth');
            Route::get('/me', [ApiAuthController::class, 'me']);
        });

    Route::get('/ads', [ApiAdvertisementController::class, 'index']);
    Route::get('/ads/{id}', [ApiAdvertisementController::class, 'show']);

    Route::prefix('c/{companySlug}')->group(function () {
        Route::get('/ads', [ApiAdvertisementController::class, 'index']);

        Route::middleware(['web', 'auth'])
            ->withoutMiddleware([VerifyCsrfToken::class])
            ->group(function () {
                Route::post('/ads', [ApiAdvertisementController::class, 'store']);
            });
    });
});
