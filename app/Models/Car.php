<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

    public const ACTIVE = 1;
    public const INACTIVE = 0;

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

    public function updateAvailabilityActive(): void
    {
        $this->availability = self::ACTIVE;
        $this->save();
    }

    public function updateAvailabilityInactive(): void
    {
        $this->availability = self::INACTIVE;
        $this->save();
    }

    /**
     * @return Model
     */
    public static function findById(int $id): ?Car
    {
        return Car::query()->where('id', $id)->first();
    }


}
