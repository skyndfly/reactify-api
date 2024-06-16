<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');

    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/{id}/models', [BrandController::class, 'getChildren'])->name('brands.children');
//    Route::apiResource('/cars', CarController::class);
//    Route::apiResource('/cars/{id}', CarController::class);
});

