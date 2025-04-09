<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    public function definition(): array
    {
        $pricePerDay = [1000.00, 2000.00, 3000.00];

        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'Seat' => $this->faker->numberBetween(1, 100),
            'price_per_day' => $this->faker->randomNumber($pricePerDay),
        ];
    }
}
