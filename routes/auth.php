<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create');
    Route::post('/register', 'store');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy');
});
