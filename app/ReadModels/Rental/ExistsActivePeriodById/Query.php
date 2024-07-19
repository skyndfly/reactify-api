<?php

namespace App\ReadModels\Rental\ExistsActivePeriodById;

use App\Models\Rental;

class Query
{
    public function fetch(string $startDate, string $endDate, int $id)
    {
        return Rental::where('car_id', $id)
            ->where('status', Rental::STATUS_ACTIVE)
            ->where('end_date', '>', $startDate)
            ->where('start_date', '<', $endDate)
            ->exists();
    }
}
