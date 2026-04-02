<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

//Route::get('/', [PublicController::class, 'index'])->name('index.default');


if (!function_exists('getPublicRoutes')) {
    function getPublicRoutes($suffix = ""): void
    {
        Route::controller(PublicController::class)->group(function () use ($suffix) {
            Route::get('/', 'index')->name('index' . $suffix);
        });
    }
}
