<?php

namespace App\Actions\Rental;

use App\Contracts\Rental\RentalActionStoreContracts;
use App\Jobs\Rental\FinishRentalJob;
use App\Models\Car;
use App\Models\Rental;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Nonstandard\Uuid;

class RentalStoreAction implements RentalActionStoreContracts
{
    /**
     * @throws ValidationException
     * @throws \Exception
     */
    public function __invoke(array $data): void
    {
        $car = Car::findById($data['car_id']);
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
        $startTime = new DateTime($data['start_date']);
        $endTime = new DateTime($data['end_date']);
        $interval = $startTime->diff($endTime);
        $hours = ($interval->days * 24) + $interval->h + ($interval->i / 60); // Расчет общего времени в часах
        $totalCost = $car['price'] * $hours;

        $car->updateAvailabilityInactive();
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


        FinishRentalJob::dispatch($newRental->id)->delay($endTime); // отложенная задача до конца аренды
    }

}
