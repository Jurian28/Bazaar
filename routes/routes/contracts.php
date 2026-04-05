<?php

use App\Http\Controllers\ContractController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

Route::prefix('contracts')
    ->middleware(['role:company'])
    ->controller(ContractController::class)
    ->group(function () {
        Route::get('index', 'index')->name('contract.download.form');

        Route::get('contract/upload/{contractCompany}', 'showUploadContract')->name('contract.upload.form');

        Route::post('contract/download/{company}', 'downloadContract')->name('contract.download');
        Route::post('contract/upload/{company}', 'uploadContract')->name('contract.upload');
        Route::post('contract/sign/{contract}', 'signContract')->name('contract.sign');
    });
