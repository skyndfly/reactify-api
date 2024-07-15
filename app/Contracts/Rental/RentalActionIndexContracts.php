<?php

namespace App\Contracts\Rental;

use App\Http\Resources\Rental\RentalCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface RentalActionIndexContracts
{
    /**
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function __invoke(int $id): RentalCollection;
}
