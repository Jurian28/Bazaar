<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

if (!function_exists('getAuthRoutes')) {
    function getAuthRoutes($suffix = ""): void {
        Route::controller(AuthController::class)->group(function () use ($suffix) {
            Route::get('/login', 'showLoginForm')->name('login' . $suffix)->middleware('guest');
            Route::post('/login', 'login')->name('login' . $suffix)->middleware('guest');
            Route::post('/logout', 'logout')->name('logout' . $suffix)->middleware('auth');

            Route::get('/register', 'showRegisterForm')->name('register' . $suffix)->middleware('guest');
            Route::post('/register', 'register')->name('register' . $suffix)->middleware('guest');
        });
    }
}
