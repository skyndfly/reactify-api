<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function carModels(): BelongsTo
    {
        return $this->belongsTo(CarModels::class, 'car_models_id');
    }

    public function cities(): BelongsTo
    {
        return $this->belongsTo(Cities::class, 'cities_id');
    }
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }


}
