<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/register', 'create')->name('user.create');
    Route::get('/register/payment', 'showPayment')->name('user.payment');
    Route::post('/register', 'store')->name('user.store');
    Route::post('/register/payment/process', 'processPayment')->name('user.process-payment');

});

Route::controller(AuthController::class)->group(function () {
    Route::get('/sign-in', 'index')->name('auth.index');
    Route::post('/sign-in', 'signIn')->name('auth.sign-in');
    Route::post('/sign-out', 'signOut')->name('auth.sign-out');
});

Route::middleware(AuthMiddleware::class)->group(function () {
    Route::controller(FriendController::class)->group(function () {
        Route::get('/friends', 'index')->name('friend.index');
        Route::post('/friends/send-request', 'store')->name('friend.store');
        Route::post('/friends/request/{friend}', 'update')->name('friend.update');
    });
    Route::controller(ChatRoomController::class)->group(function () {
        Route::get('/chat-rooms/friend/{friend}', 'friend')->name('chat-room.friend');
        Route::get('/chat-rooms/{chatRoom}', 'show')->name('chat-room.show');
    });
    Route::controller(ChatController::class)->group(function () {
        Route::post('/chats/send/{chatRoom}/{friend}', 'store')->name('chat.store');
    });
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notification.index');
    });
});
