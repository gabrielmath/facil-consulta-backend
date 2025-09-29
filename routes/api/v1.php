<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/test', [HomeController::class, 'test'])->name('test');

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
