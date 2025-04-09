<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Basic',
                'description' => 'Basic package with limited features.',
                'Seat' => 5,
                'price_per_day' => 1000.00,
            ],
            [
                'name' => 'Standard',
                'description' => 'Standard package with additional features.',
                'Seat' => 10,
                'price_per_day' => 2000.00,
            ],
            [
                'name' => 'Premium',
                'description' => 'Premium package with all features.',
                'Seat' => 15,
                'price_per_day' => 3000.00,
            ],
        ];

        foreach ($packages as $package) {
            Package::query()->create($package);
        }
    }
}
