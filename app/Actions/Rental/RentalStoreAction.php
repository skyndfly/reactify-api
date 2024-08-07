<?php

namespace App\Actions\Rental;

use App\Contracts\Rental\RentalActionStoreContracts;
use App\Helpers\DateTimeHelper;
use App\Jobs\Rental\FinishRentalJob;
use App\Models\Car;
use App\Models\Rental;
use App\ReadModels\Rental\ExistsActivePeriodById\Query as ExistsActivePeriodByIdQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RentalStoreAction implements RentalActionStoreContracts
{
    private ExistsActivePeriodByIdQuery $existsActivePeriodByIdQuery;

    public function __construct(ExistsActivePeriodByIdQuery $existsActivePeriodByIdQuery)
    {
        $this->existsActivePeriodByIdQuery = $existsActivePeriodByIdQuery;
    }


    /**
     * @throws \Exception
     */
    public function __invoke(array $data): void
    {
        $car = Car::findById($data['car_id']);
        $data['start_date'] = Carbon::now()->toDateTimeString();
        $data['user_id'] = Auth::user()->id;
        if (!$car['availability']) {
            throw new \DomainException("Car is available for rent.");
        }

        // Проверка, что время аренды не пересекается с уже существующими арендами
        $overlappingRentals = $this->existsActivePeriodByIdQuery->fetch(
            $data['start_date'],
            $data['end_date'],
            $data['car_id']
        );
        if (DateTimeHelper::compareDateTimeInMinutes($data['start_date'], $data['end_date']) < 5){
            throw new \DomainException("Time most likely is overlapping.");
        }
        if ($overlappingRentals) {
            throw new \DomainException("The car is already rented for the selected time period.");
        }
        $interval = DateTimeHelper::hourCalculate($data['start_date'], $data['end_date']);
        $totalCost = $car['price'] * $interval;
        $newRental = Rental::create(
            $data['car_id'],
            $data['user_id'],
            $data['start_date'],
            $data['end_date'],
            Rental::STATUS_ACTIVE,
            $totalCost,
        );
        if (!$newRental->save()) {
            throw new \DomainException('Save rental error.');
        }
        FinishRentalJob::dispatch($newRental->id)->delay($interval*3600); // отложенная задача до конца аренды
    }

}
