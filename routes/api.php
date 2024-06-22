<?php

use App\Http\Controllers\Order\Api\OrderController;
use App\Http\Controllers\User\Api\UserController;
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

//Route::middleware(['is.login'])->group(function () {
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
