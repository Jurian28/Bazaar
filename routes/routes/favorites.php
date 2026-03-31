<?php


use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::controller(FavoriteController::class)
    ->middleware(['role:user'])->group(function () {
    Route::post('/ad/favorite', 'favorite')->name('ad.favorite');
    Route::get('/favorites', 'favorites')->name('favorites');
});
