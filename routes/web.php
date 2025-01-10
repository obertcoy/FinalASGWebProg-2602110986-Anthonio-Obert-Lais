<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/register', 'create')->name('user.create');
    Route::post('/register', 'store')->name('user.store');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/sign-in', 'index')->name('auth.index');
    Route::post('/sign-in', 'signIn')->name('auth.sign-in');
    Route::post('/sign-out', 'signOut')->name('auth.sign-out');
});
