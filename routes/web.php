<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
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

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'create');
    Route::post('/register', 'store');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'create');
    Route::post('/login', 'store');
    Route::post('/logout', 'destroy');
});
