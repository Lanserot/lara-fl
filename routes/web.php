<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Tools\SwaggerController;
use App\Http\Controllers\User\Admin\AdminController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\Chat\ChatController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegistrationController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('main');

Route::middleware(['not.login'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');

        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/me', [AuthController::class, 'me']);
    });
});

Route::middleware(['is.login'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('show/{id}', [UserController::class, 'show'])->name('user.show');
        Route::get('my_list', [OrderController::class, 'myList'])->name('user.my_list');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('chat', [ChatController::class, 'index'])->name('user.chat');
    });
    Route::prefix('site')->group(function () {
        Route::get('about', [AboutController::class, 'index']);
        Route::get('order', [OrderController::class, 'index'])->name('order');
    });
    Route::prefix('api/documentation')->group(function () {
        Route::get('users', [SwaggerController::class, 'users']);
        Route::get('orders', [SwaggerController::class, 'orders']);
        Route::get('json/users', function () {
            return response()->file(storage_path('api-docs/api-users-docs.json'));
        });
        Route::get('json/orders', function () {
            return response()->file(storage_path('api-docs/api-orders-docs.json'));
        });
    });

});
Route::prefix('user/admin')->group(function () {
    Route::middleware(['is.admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index']);

    });
});
Route::get('/order/list', [OrderController::class, 'list'])->name('order.list');
Route::get('/order/category/{category}', [OrderController::class, 'category'])->name('order.category');
Route::get('/order/show/{id}', [OrderController::class, 'show'])->name('order.show');

