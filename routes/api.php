<?php

use App\Http\Controllers\Order\Api\OrderController;
use App\Http\Controllers\User\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('users', UserController::class)->names(
        [
            'update' => 'user.update',
            'show' => 'user.show',
        ]
    )->only(['update', 'show']);
    Route::apiResource('orders', OrderController::class)->names(
        [
            'store' => 'order.create'
        ]
    )->only(['store']);
});
Route::middleware(['not.login'])->group(function () {
    Route::apiResource('users', UserController::class)->names(['store' => 'user.create',])->only(['show']);
});
