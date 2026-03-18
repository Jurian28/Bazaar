<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

Route::prefix('company')
    ->middleware(['auth','role:company'])
    ->group(function () {
        Route::get('settings', [CompanyController::class, 'showSettings'])->name('company.showSettings');
        Route::put('settings', [CompanyController::class, 'updateSettings'])->name('company.updateSettings');
    });
