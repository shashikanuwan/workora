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
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'Seat' => $this->faker->numberBetween(1, 100),
            'price_per_day' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
