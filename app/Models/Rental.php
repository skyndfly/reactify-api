<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    use HasFactory;
    public const STATUS_ACTIVE = 'active';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_PENDING = 'pending';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public static function create(
        int $carID,
        int $userID,
        string $startDate,
        string $EndDate,
        string $status,
        float $price,
    ): Rental
    {
        $rental = new Rental();
        $rental['car_id'] = $carID;
        $rental['user_id'] = $userID;
        $rental['start_date'] = $startDate;
        $rental['end_date'] = $EndDate;
        $rental['status'] = $status;
        $rental['price'] = $price;

        return $rental;
    }
}
