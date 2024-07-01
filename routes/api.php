<?php

use App\Http\Controllers\Files\FileUploadController;
use App\Http\Controllers\Order\Api\OrderController;
use App\Http\Controllers\User\Api\UserController;
use Illuminate\Support\Facades\Route;

//'index' => 'posts.list',
//'store' => 'posts.create',
//'show' => 'posts.view',
//'update' => 'posts.edit',
//'destroy' => 'posts.delete'
Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('users', UserController::class)->names(
        [
            'update' => 'user.update',
            'show' => 'user.show',
        ]
    )->only(['update', 'show']);
    Route::apiResource('orders', OrderController::class)->names(
        [
            'store' => 'order.create',
            'show' => 'order.view',
        ]
    )->only(['store', 'show']);
    Route::apiResource('files', FileUploadController::class)->names(
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
