<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::prefix('v1')->name('v1.')->group(function () {
        require __DIR__ . '/api/v1.php';
    });
});
