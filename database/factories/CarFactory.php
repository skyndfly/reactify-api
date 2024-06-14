<?php

namespace Database\Factories;

use App\Models\Car;
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
        $carBrands = [
            'Audi',
            'BMW',
            'Chevrolet',
            'Dodge',
            'Ford',
            'Honda',
            'Hyundai',
            'Jaguar',
            'Kia',
            'Lexus',
            'Mazda',
            'Mercedes-Benz',
            'Nissan',
            'Porsche',
            'Subaru',
            'Tesla',
            'Toyota',
            'Volkswagen',
            'Volvo',
            'Land Rover'
        ];
        $carModels = [
            'Audi A3',
            'BMW 3 Series',
            'Chevrolet Camaro',
            'Dodge Charger',
            'Ford Mustang',
            'Honda Civic',
            'Hyundai Sonata',
            'Jaguar F-Pace',
            'Kia Sportage',
            'Lexus RX',
            'Mazda MX-5',
            'Mercedes-Benz E-Class',
            'Nissan Altima',
            'Porsche 911',
            'Subaru Forester',
            'Tesla Model S',
            'Toyota Corolla',
            'Volkswagen Golf',
            'Volvo XC60',
            'Land Rover Range Rover',
            'Audi Q5',
            'BMW 5 Series',
            'Chevrolet Silverado',
            'Dodge Challenger',
            'Ford Explorer',
        ];
        return [
            'brand' => $carBrands[array_rand($carBrands)],
            'model' => $carModels[array_rand($carModels)],
            'year' => $this->faker->year(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomFloat(2, 10),
        ];
    }
}
