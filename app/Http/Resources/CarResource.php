<?php

namespace App\Http\Resources;

use App\Http\Resources\Brand\BrandResource;
use App\Http\Resources\CarModels\CarModelsResource;
use App\Http\Resources\Cities\CitiesResource;
use App\Http\Resources\Region\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'city' => new CitiesResource($this->cities),
            'region' => new RegionResource($this->region),
            'price' => $this->price,
            'availability' => $this->availability,
            'year' => $this->year,
            'fuel_type' => $this->fuel_type,
            'transmission' => $this->transmission,
            'seats' => $this->seats,
            'color' => $this->color,
            'image' => $this->image,
            'description' => $this->description,
        ];
    }
}
