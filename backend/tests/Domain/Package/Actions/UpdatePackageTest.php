<?php

use App\Models\Package;
use Workora\Package\Actions\UpdatePackage;

use function Pest\Laravel\assertDatabaseHas;

it('can update package', function () {
    $package = Package::factory()->create();

    $updatedPackage = resolve(UpdatePackage::class)
        ->execute(
            $package,
            'Updated Package',
            'Updated Description',
            10,
            2000.0,
        );

    expect($updatedPackage)->toBeInstanceOf(Package::class);

    assertDatabaseHas(Package::class, [
        'id' => $package->id,
        'name' => 'Updated Package',
        'description' => 'Updated Description',
        'seat' => 10,
        'price_per_day' => 2000.0,
    ]);
});
