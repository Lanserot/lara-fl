<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['is.login'])->group(function () {
    Route::apiResource('users', \App\Http\Controllers\User\Api\UserController::class)->names(
        [
            'store' => 'user.create',
            'update' => 'user.update',
            'show' => 'user.show',
        ]
    )->only(['store', 'update', 'show']);

    Route::apiResource('orders', \App\Http\Controllers\Order\Api\OrderController::class)->names(
        [
            'store' => 'order.create'
        ]
    )->only(['store']);
});

