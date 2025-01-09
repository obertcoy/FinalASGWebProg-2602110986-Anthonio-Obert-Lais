<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::controller(UserController::class)->group(function () {
    Route::get('/register', 'create')->name('user.create');
    Route::post('/register', 'store')->name('user.store');
});
