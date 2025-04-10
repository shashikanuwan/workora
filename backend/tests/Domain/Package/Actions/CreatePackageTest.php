<?php

use App\Models\Package;
use Workora\Package\Actions\CreatePackage;

use function Pest\Laravel\assertDatabaseHas;

it('can create package', function () {
    $package = resolve(CreatePackage::class)
        ->execute(
            'Test Package',
            'Test Description',
            5,
            1000.0,
        );

    expect($package)->toBeInstanceOf(Package::class);

    assertDatabaseHas(Package::class, [
        'name' => 'Test Package',
        'description' => 'Test Description',
        'seat' => 5,
        'price_per_day' => 1000.0,
    ]);
});
