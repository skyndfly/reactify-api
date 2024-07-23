<?php

namespace App\Actions\Rental;

use App\Contracts\Rental\RentalActionIndexContracts;
use App\Http\Resources\Rental\RentalCollection;
use App\Models\Rental;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RentalIndexAction implements RentalActionIndexContracts
{
    /**
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function __invoke(int $id): RentalCollection
    {
        $model = Rental::query()->where('user_id', $id)->orderBy('end_date', 'DESC')->paginate(10);
        if ($model->isEmpty()) {
            throw new ModelNotFoundException("Not found rentals");
        }
        return new RentalCollection($model);
    }

}
