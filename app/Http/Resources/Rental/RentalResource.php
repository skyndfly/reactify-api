<?php

namespace App\Http\Resources\Rental;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'car' => new CarForRentalResource($this->car),
            'start_date'=> $this->start_date,
            'end_date'=> $this->end_date,
            'price'=> $this->price,
            'status'=> $this->status,

        ];
    }
}
