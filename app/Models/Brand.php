<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'brand';

    public function models(): HasMany
    {
        return $this->hasMany(CarModels::class, 'brand_id', 'id');
    }
}
