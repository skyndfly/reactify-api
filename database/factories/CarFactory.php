<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModels;
use App\Models\Cities;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{

    protected $model = Car::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomModel = CarModels::all()->random();
        $randomCities = Cities::all()->random();

        return [
            'brand_id' => $randomModel->brand_id, // Получаем случайный бренд
            'car_models_id' => $randomModel->id,
            'cities_id' => $randomCities->id,
            'region_id' => $randomCities->region_id,
            'price' => fake()->randomFloat(2, 100, 1000),
            'availability' => true,
            'year' => fake()->numberBetween(2000, 2024),
            'fuel_type' => fake()->randomElement(['Gasoline', 'Diesel', 'Electric']),
            'transmission' => fake()->randomElement(['Manual', 'Automatic']),
            'seats' => 5,
            'color' => fake()->randomElement(['green', 'red', 'white', 'blue', 'orange']),
            'image' => 'car1.jpg',
            'description' => fake()->text(100),
        ];
    }
}
