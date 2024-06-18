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
});

Route::get('user/show/{id}', [\App\Http\Controllers\User\UserController::class, 'show'])->name('user.show');
Route::get('user/edit/{id}', [\App\Http\Controllers\User\UserController::class, 'edit'])->name('user.edit');

Route::apiResource('user', \App\Http\Controllers\User\Api\UserController::class)->names(
    [
        'store' => 'user.create',
        'update' => 'user.update'
    ]
)->only(['store', 'update']);



Route::get('/user/logout', [\App\Http\Controllers\User\LoginController::class, 'logout'])->name('logout');
Route::get('/about', [\App\Http\Controllers\Site\AboutController::class, 'index']);

Route::middleware(['is.login'])->group(function () {
    Route::get('/order', [\App\Http\Controllers\Order\OrderController::class, 'index']);

    Route::apiResource('order', \App\Http\Controllers\Order\Api\OrderController::class)->names(
        [
            'store' => 'order.create',
            'update' => 'order.update'
        ]
    )->only(['store', 'update']);
});
