<?php

namespace Database\Seeders;

use App\Models\Extend;
use Illuminate\Database\Seeder;

class ExtendSeeder extends Seeder
{
    public function run(): void
    {
        Extend::factory(4)->create();
    }
}
