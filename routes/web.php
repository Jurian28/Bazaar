<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;
require __DIR__.'/auth.php';
require __DIR__.'/companySettings.php';


Route::get('/', [PublicController::class, 'index'])->name('index.default');
getAuthRoutes(NO_SLUG_ROUTE_SUFFIX);


Route::prefix('c/{companySlug}')->group(function () {
    Route::get('/', [PublicController::class, 'index'])->name('index');
    getAuthRoutes();
});


























//Route::get("/", function () {
//    return view('home/index');
//});

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
