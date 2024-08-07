<?php

use App\Http\Controllers\Files\AvatarUploadController;
use App\Http\Controllers\Order\Api\OrderController;
use App\Http\Controllers\Order\Api\OrderResponseController;
use App\Http\Controllers\User\Api\UserController;
use Illuminate\Support\Facades\Route;

//'index' => 'posts.list',
//'store' => 'posts.create',
//'show' => 'posts.view',
//'update' => 'posts.edit',
//'destroy' => 'posts.delete'
Route::middleware(['jwt.auth', 'rate.limit'])->group(function () {
    Route::apiResource('users', UserController::class)->names(
        [
            'update' => 'user.update',
            'show' => 'user.show',
        ]
    )->only(['update', 'show']);
    Route::get('/order/can_response', [OrderController::class, 'canResponse']);
    Route::apiResource('orders', OrderController::class)->names(
        [
            'store' => 'order.create',
            'show' => 'order.view',
        ]
    )->only(['store', 'show']);
    Route::apiResource('order-response', OrderResponseController::class)->names(
        [
            'store' => 'order-response.create',
        ]
    )->only(['store']);
    Route::apiResource('files', AvatarUploadController::class)->names(
        [
            'store' => 'file.upload'
        ]
    )->only(['store']);
});

Route::middleware(['not.login'])->group(function () {
    Route::apiResource('users', UserController::class)->names(
        ['store' => 'user.create']
    )->only(['store']);
});
