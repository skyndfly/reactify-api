<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\RentalController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('/cars/filter', [CarController::class, 'filter'])->name('cars.filter');
    Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');

    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/{id}/models', [BrandController::class, 'brandsChildren'])->name('brands.children');

    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');




    Route::middleware('auth:sanctum')->group(function () {
        Route::post('rental', [RentalController::class, 'store'])->name('rental.store');
    });
//    Route::apiResource('/cars', CarController::class);
//    Route::apiResource('/cars/{id}', CarController::class);
});

