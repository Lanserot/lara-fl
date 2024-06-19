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

Route::middleware(['is.login'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('show/{id}', [\App\Http\Controllers\User\UserController::class, 'show'])->name('user.show');
        Route::get('edit/{id}', [\App\Http\Controllers\User\UserController::class, 'edit'])->name('user.edit');
        Route::get('logout', [\App\Http\Controllers\User\LoginController::class, 'logout'])->name('logout');
    });

    Route::apiResource('user', \App\Http\Controllers\User\Api\UserController::class)->names(
        [
            'store' => 'user.create',
            'update' => 'user.update'
        ]
    )->only(['store', 'update']);

    Route::get('/about', [\App\Http\Controllers\Site\AboutController::class, 'index']);
    Route::get('/order', [\App\Http\Controllers\Order\OrderController::class, 'index']);
    Route::apiResource('order', \App\Http\Controllers\Order\Api\OrderController::class)->names(
        [
            'store' => 'order.create'
        ]
    )->only(['store']);

});

Route::get('/api/documentation/users', [\App\Http\Controllers\User\Api\UserController::class, 'index']);
Route::get('/api/documentation/json', function () {
    return response()->file(storage_path('api-docs/api-docs.json'));
});
