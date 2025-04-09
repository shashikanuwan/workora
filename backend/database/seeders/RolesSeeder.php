<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        Role::query()->insert([
            ['name' => RoleEnum::ADMIN, 'guard_name' => 'web'],
            ['name' => RoleEnum::USER, 'guard_name' => 'web'],
        ]);
    }
}
