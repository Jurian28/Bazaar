<?php

use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

Route::controller(HistoryController::class)->group(function () {
    Route::get('/user/saleHistory', 'userSaleHistory')->name('user.saleHistory');
    Route::get('/user/rentalHistory', 'userRentalHistory')->name('user.rentalHistory');


    Route::get('/seller/saleHistory', 'sellerSaleHistory')->name('seller.saleHistory');
    Route::get('/seller/agenda', 'sellerRentalOverview')->name('seller.rentalOverview');
});
