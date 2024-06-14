<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        return new CarCollection(Car::paginate(6));
    }

    public function show(int $id)
    {

        return new CarResource(Car::query()->where('id', $id)->first());
    }
}
