<?php

namespace App\Contracts\Rental;

use Illuminate\Validation\ValidationException;

interface RentalActionStoreContracts
{
    /**
     * @throws ValidationException
     * @throws \Exception
     */
    public function __invoke(array $data): void;
}
