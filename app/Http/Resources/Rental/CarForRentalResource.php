<?php

namespace App\Http\Resources\Rental;

use App\Http\Resources\Brand\BrandResource;
use App\Http\Resources\CarModels\CarModelsResource;
use App\Http\Resources\Cities\CitiesResource;
use App\Http\Resources\Region\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarForRentalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'brand' => new BrandResource($this->brand),
            'car_models' => new CarModelsResource($this->carModels),
        ];
    }
}
