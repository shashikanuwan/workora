<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        collect(range(1, 2))->each(function ($id) {
            User::factory()->create([
                'name' => "Admin {$id}",
                'email' => "admin_{$id}@rentix.com",
            ])
                ->assignRole(Role::ADMIN->value);
        });

        collect(range(1, 2))->each(function ($id) {
            User::factory()->create([
                'name' => "User {$id}",
                'email' => "user_{$id}@rentix.com",
            ])
                ->assignRole(Role::USER->value);
        });
    }
}
