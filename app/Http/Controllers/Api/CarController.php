<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @OA\Get (
 *     path="/api/v1/cars",
 *     summary="Get all cars by pagination",
 *     tags={"Car"},
 *
 *     @OA\RequestBody(
 *
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Ok"
 *     ),
 * ),
 * @OA\Get (
 *     path="/api/v1/cars/{id}",
 *     summary="Get car by id",
 *     tags={"Car"},
 *
 *     @OA\Parameter(
 *          name="id",
 *          in="path",
 *          required=true,
 *          description="ID of the car",
 *          example=21,
 *          @OA\Schema(
 *              type="integer",
 *              format="int64"
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="id", type="integer", example=21),
 *              @OA\Property(property="brand", type="string", example="BMW"),
 *              @OA\Property(property="model", type="string", example="X5"),
 *              @OA\Property(property="year", type="integer", example=2021),
 *              @OA\Property(property="color", type="string", example="black"),
 *              @OA\Property(property="price", type="number", example=12.5),
 *      )
 *      ),
 *     @OA\Response(
 *         response=404,
 *         description="Car not found"
 *     )
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

        try {
            $car = Car::findOrFail($id);
            return new CarResource($car);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Car not found'], 404);
        }
    }
}
