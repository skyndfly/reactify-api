<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'car_id' => 'required|exists:car_models,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required',
            'end_date' => 'required',
            'duration' => 'required',
        ]);

        return Rental::create($data);
    }
}
