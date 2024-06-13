<?php

use App\Http\Controllers\Api\CarController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {
//    Route::get('cars', [CarController::class, 'index'])->name('cars.index');
    Route::apiResource('/cars', CarController::class);
});

