<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class CarController extends Controller
{

    /**
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
     *      ),     *
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *          @OA\JsonContent(
     *                 @OA\Property (
     *                      property="data",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="brand", type="object",
     *                              @OA\Property (property="id", type="integer", example="2"),
     *                              @OA\Property (property="name", type="string", example="Volkswagen"),
     *                          ),
     *                          @OA\Property(property="car_models", type="object",
     *                              @OA\Property (property="id", type="integer", example="5"),
     *                              @OA\Property (property="name", type="string", example="Passat"),
     *                          ),
     *                          @OA\Property(property="price", type="string", format="float", example="709.89"),
     *                          @OA\Property(property="availability", type="integer", example="1"),
     *                          @OA\Property(property="year", type="integer", example="2024"),
     *                          @OA\Property(property="fuel_type", type="string", example="Electric"),
     *                          @OA\Property(property="transmission", type="string", example="Manual"),
     *                          @OA\Property(property="seats", type="integer", example="5"),
     *                          @OA\Property(property="color", type="string", example="white"),
     *                          @OA\Property(property="image", type="string", example="car1.jpg"),
     *                          @OA\Property(property="description", type="string", example="In et enim laborum. Iste ex suscipit et tenetur et.")
     *                      )
     *                 )
     *          )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Car not found"
     *     )
     * ),
     */
    public function show(int $id)
    {

        try {
            $car = Car::findOrFail($id);
            return new CarResource($car);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Car not found'], 404);
        }
    }
    // TODO: add swagger documentation for this method
    public function index(Request $request): CarCollection
    {
        $filters = $request->all();

        $query = Car::query();

        foreach ($filters as $field => $value) {
            if ($value !== null && $value !== '') {
                $query->where($field, $value);
            }
        }

        $filteredCars = $query->where('availability', 1)->paginate(6);

        return new CarCollection($filteredCars);
    }
}
