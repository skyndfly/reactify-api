<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Car;

/**
 * @OA\Info(
 *     title="REACTIFY API",
 *     version="1.0"
 * ),
 * @OA\PathItem(
 *      path="/api/v1/cars"
 * )
 * @OA\Get (
 *     path="/api/v1/cars",
 *     summary="Get all cars by pagination",
 *
 *     @OA\RequestBody(),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok"
 *     ),
 * ),
 */
class CarController extends Controller
{
    public function index()
    {
        return new CarCollection(Car::paginate(6));
    }

    public function show(int $id)
    {

        return new CarResource(Car::query()->where('id', $id)->first());
    }
}
