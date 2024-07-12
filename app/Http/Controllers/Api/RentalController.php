<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
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
     * @throws \Exception
     */
    public function store(Request $request)
    {

        try {
            $data = $request->validate([
                'car_id' => 'required|exists:car_models,id',
                'user_id' => 'required|exists:users,id',
                'start_date' => 'required|date|after_or_equal:now',
                'end_date' => 'required|date|after:start_date',
            ]);
            $car = Car::find($data['car_id']);
            if (!$car['availability']) {
                $uuid = Uuid::uuid4();
                $message = "The car is not available for rent. Error code - {$uuid}";
                $logMessage = "Class: " . __METHOD__ . " | Line: " . __LINE__ . " | " . $message;
                Log::error($logMessage);
                throw ValidationException::withMessages(['rental' => $message]);
            }
            // Проверка, что время аренды не пересекается с уже существующими арендами
            $overlappingRentals = Rental::where('car_id', $data['car_id'])
                ->whereRaw('? < end_date', [$data['start_date']])
                ->whereRaw('? > start_date', [$data['end_date']])
                ->exists();

            if ($overlappingRentals) {
                $uuid = Uuid::uuid4();
                $message = "The car is already rented for the selected time period. Error code - {$uuid}";
                $logMessage = "Class: " . __METHOD__ . " | Line: " . __LINE__ . " | " . $message;
                Log::error($logMessage);
                throw ValidationException::withMessages(['rental' => $message]);
            }

            $startTime = new \DateTime($data['start_date']);
            $endTime = new \DateTime($data['end_date']);
            $interval = $startTime->diff($endTime);
            $hours = ($interval->days * 24) + $interval->h + ($interval->i / 60); // Расчет общего времени в часах
            $totalCost = $car['price'] * $hours;

            $newRental = Rental::create(
                $data['car_id'],
                $data['user_id'],
                $data['start_date'],
                $data['end_date'],
                Rental::STATUS_ACTIVE,
                $totalCost,
            );
            if (!$newRental->save()) {
                $uuid = Uuid::uuid4();
                $message = "Something went wrong. Error code - {$uuid}";
                $logMessage = "Class: " . __METHOD__ . " | Line: " . __LINE__ . " | " . $message;
                Log::error($logMessage);
                throw ValidationException::withMessages(['rental' => $message]);
            }
            return response()->json(['message' => 'Success.'], 200);

        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 422);
        }
    }
}
