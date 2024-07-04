<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RentalController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/rental",
     *     summary="Add new rental",
     *     tags={"Rental"},
     *     @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          description="Bearer token"
     *      ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema (
     *                 type="object",
     *                 required={"car_id", "user_id", "start_date", "end_date"},
     *                  @OA\Property(
     *                      property="car_id",
     *                      type="integer",
     *                      description="Car id",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer",
     *                      description="User id",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="start_date",
     *                      type="string",
     *                      description="Start rental date",
     *                      example="2024-07-03"
     *                  ),
     *                  @OA\Property(
     *                      property="end_date",
     *                      type="string",
     *                      description="End rental date",
     *                      example="2024-07-03"
     *                  )
     *             )
     *         )
     *     ) ,
     *     @OA\Response(
     *         response=200,
     *         description="Success."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validate exception",
     *         @OA\JsonContent(
     *             @OA\Property (
     *                 property="message",
     *                 type="object",
     *                 description="Errors object",
     *                 @OA\Property (
     *                  property="car_id",
     *                  type="array",
     *                  @OA\Items(
     *                      type="string",
     *                      example="Car not found"
     *                  )
     *                 )
     *             )
     *
     *         )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function store(Request $request)
    {

        try {
            $data = $request->validate([
                'car_id' => 'required|exists:car_models,id',
                'user_id' => 'required|exists:users,id',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            Rental::create($data);
            return response()->json(['message' => 'Success.'], 200);

        }catch (ValidationException $exception){
            return response()->json(['errors' => $exception->errors()], 422);
        }
    }
}
