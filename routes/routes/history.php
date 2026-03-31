<?php

use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

Route::controller(HistoryController::class)->group(function () {
    Route::get('/user/saleHistory', 'userSaleHistory')->name('user.saleHistory')->middleware('role:user');
    Route::get('/user/rentalHistory', 'userRentalHistory')->name('user.rentalHistory')->middleware('role:user');


    Route::get('/seller/saleHistory', 'sellerSaleHistory')->name('seller.saleHistory')->middleware('role:seller');
    Route::get('/seller/agenda', 'sellerRentalOverview')->name('seller.rentalOverview')->middleware('role:seller');
});
