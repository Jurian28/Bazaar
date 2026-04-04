<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

Route::prefix('company')
    ->middleware(['role:company'])
    ->group(function () {
        Route::get('settings', [CompanyController::class, 'showSettings'])->name('company.showSettings');
        Route::put('settings', [CompanyController::class, 'updateSettings'])->name('company.updateSettings');

        Route::get('components', [CompanyController::class, 'components'])->name('company.components');
        Route::post('components/image', [CompanyController::class, 'addImage'])->name('company.components.addImage');
        Route::post('components/text', [CompanyController::class, 'addText'])->name('company.components.addText');
        Route::post('components/ad', [CompanyController::class, 'addAd'])->name('company.components.addAd');
        Route::post('components/changeOrder/{direction}', [CompanyController::class, 'changeOrder'])->name('company.components.changeOrder');
        Route::post('components/delete', [CompanyController::class, 'delete'])->name('company.components.delete');

        Route::get('import-export', [CompanyController::class, 'showImportExport'])->name('company.importExport');
    });
