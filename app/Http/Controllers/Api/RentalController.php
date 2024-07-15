<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Rental\RentalActionStoreContracts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rental\RentalIndexRequest;
use App\Http\Requests\Rental\RentalStoreRequest;
use App\Http\Resources\Rental\RentalCollection;
use App\Models\Rental;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Nonstandard\Uuid;

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
     * @throws Exception
     */
    public function store(RentalStoreRequest $request, RentalActionStoreContracts $rental): JsonResponse
    {
        try {
            $rental($request->validated());
            return response()->json(['message' => 'Success.'], 200);

        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 422);
        }
    }


    public function index(int $id): JsonResponse|RentalCollection
    {
        try {
            $model = Rental::query()->where('user_id', $id)->paginate(10);
            if ($model->isEmpty()) {
                throw new ModelNotFoundException("Model not found");
            }

            return new RentalCollection($model);
        } catch (ModelNotFoundException $e) {
            $uuid = Uuid::uuid4();
            $logMessage = "Class: " . __METHOD__ . " | Line: " . __LINE__ . " | " . "{$e->getMessage()} -  {$uuid}";
            Log::error($logMessage);
            return response()->json(['errors' => $e->getMessage(), 'errorCode' => $uuid], 422);
        }
    }
}
