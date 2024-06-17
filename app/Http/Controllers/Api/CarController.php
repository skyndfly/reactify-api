<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
 *              @OA\Property(property="brand", type="object",
 *                  @OA\Property (property="id", type="integer"),
 *                  @OA\Property (property="name", type="string"),
 *              ),
 *               @OA\Property(property="car_models", type="object",
 *                   @OA\Property (property="id", type="integer"),
 *                   @OA\Property (property="name", type="string"),
 *               ),
 *              @OA\Property(property="price", type="string", format="float"),
 *              @OA\Property(property="availability", type="integer"),
 *              @OA\Property(property="year", type="integer"),
 *              @OA\Property(property="fuel_type", type="string"),
 *              @OA\Property(property="transmission", type="string"),
 *              @OA\Property(property="seats", type="integer"),
 *              @OA\Property(property="color", type="string"),
 *              @OA\Property(property="image", type="string"),
 *              @OA\Property(property="description", type="string")
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
    public function filter(Request $request): CarCollection
    {
        $filters = $request->all();

        $query = Car::query();

        foreach ($filters as $field => $value) {
            if ($value !== null && $value !== '') {
                $query->where($field, $value);
            }
        }

        $filteredCars = $query->paginate(10);

        return new CarCollection($filteredCars);
    }
}
