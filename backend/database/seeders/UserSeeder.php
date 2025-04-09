<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        collect(range(1, 2))->each(function ($id) {
            User::factory()->create([
                'name' => "Admin {$id}",
                'email' => "admin_{$id}@workora.com",
            ])
                ->assignRole(Role::ADMIN->value);
        });

        collect(range(1, 2))->each(function ($id) {
            User::factory()
                ->has(Booking::factory()->count(5))
                ->create([
                    'name' => "User {$id}",
                    'email' => "user_{$id}@workora.com",
                ])
                ->assignRole(Role::USER->value);
        });
    }
}
