<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

//Route::get('/', [PublicController::class, 'index'])->name('index.default');


Route::get('/profile/{user}', [PublicController::class, 'viewProfile'])->name('profile');
Route::post('/profile/{user}', [ReviewController::class, 'reviewProfile'])->name('profile.review');

if (!function_exists('getPublicRoutes')) {
    function getPublicRoutes($suffix = ""): void
    {
        Route::controller(PublicController::class)->group(function () use ($suffix) {
            Route::get('/', 'index')->name('index' . $suffix);
        });
    }
}
