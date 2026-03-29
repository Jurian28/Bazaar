<?php


use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::controller(FavoriteController::class)->group(function () {
    Route::post('/ad/favorite', 'favorite')->name('ad.favorite');
    Route::get('/favorites', 'favorites')->name('favorites');
});
