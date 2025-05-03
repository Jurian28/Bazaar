<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdController;
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

Route::controller(AdController::class)->group(function () {
    Route::get('/index-ad', 'index');
    Route::get('/create-ad', 'showCreateForm');
    Route::post('/create-ad', 'submitCreateForm');
    Route::get('/agenda', 'agenda');
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

