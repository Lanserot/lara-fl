<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::middleware(['not.login'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/login', [\App\Http\Controllers\User\LoginController::class, 'index'])->name('login');
        Route::get('/login/get', [\App\Http\Controllers\User\LoginController::class, 'get'])->name('login-get');
        Route::get('/registration', [\App\Http\Controllers\User\RegistrationController::class, 'index'])->name('registration');
    });
    Route::apiResource('users', \App\Http\Controllers\User\UserController::class)->names(['store' => 'users.create']);

});

Route::get('/user/logout', [\App\Http\Controllers\User\LoginController::class, 'logout'])->name('logout');
Route::get('/about', [\App\Http\Controllers\Site\AboutController::class, 'index']);
Route::get('/order', [\App\Http\Controllers\Order\OrderController::class, 'index']);
Route::post('/order', [\App\Http\Controllers\Order\OrderController::class, 'post'])->name('order-post');