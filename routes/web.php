<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::middleware(['not.login'])->group(function () {
    Route::get('/user/login', [\App\Http\Controllers\User\LoginController::class, 'index'])->name('login');
    Route::get('/user/login/get', [\App\Http\Controllers\User\LoginController::class, 'get'])->name('login-get');
    Route::get('/user/registration', [\App\Http\Controllers\User\RegistrationController::class, 'index'])->name('registration');
    Route::post('/user/registration', [\App\Http\Controllers\User\RegistrationController::class, 'post']);
});


Route::get('/user/logout', [\App\Http\Controllers\User\LoginController::class, 'logout'])->name('logout');



