<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/company.php';
require __DIR__.'/auth.php';



Route::prefix('{companySlug}')->group(function () {
    Route::get('/', [PublicController::class, 'index'])->name('index');
});





Route::get("/", function () {
    return view('home/index');
});

Route::get('/agenda', function () {
    return view('agenda/index');
});

Route::get('/favorites', function () {
    return view('favorites/index');
});

Route::get('/history', function () {
    return view('history/index');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index');
});
