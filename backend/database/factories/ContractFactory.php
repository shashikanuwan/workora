<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{
    public function definition(): array
    {
        return [
            'document' => $this->faker->unique()->word().'.pdf',
            'user_id' => User::factory(),
            'booking_id' => Booking::factory(),
        ];
    }
}
