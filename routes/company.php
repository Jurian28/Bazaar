<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

Route::prefix('company')
    ->middleware(['auth','role:company'])
    ->group(function () {
        Route::get('settings', [CompanyController::class, 'edit'])->name('company.edit');
        Route::put('settings', [CompanyController::class, 'update'])->name('company.update');
    });
