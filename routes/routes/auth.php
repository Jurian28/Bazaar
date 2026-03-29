<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

function getAuthRoutes($suffix = ""): void {
    Route::controller(AuthController::class)->group(function () use ($suffix) {
        Route::get('/login', 'showLoginForm')->name('login' . $suffix);
        Route::post('/login', 'login')->name('login' . $suffix);
        Route::post('/logout', 'logout')->name('logout' . $suffix);

        Route::get('/register', 'showRegisterForm')->name('register' . $suffix);
        Route::post('/register', 'register')->name('register' . $suffix);
    });
}
