<?php

use App\Models\Package;
use Workora\Package\Actions\CreatePackage;

it('can create package', function () {
    $package = resolve(CreatePackage::class)
        ->execute(
            'Test Package',
            'Test Description',
            5,
            1000.0,
        );

    expect($package)->toBeInstanceOf(Package::class)
        ->and($package->name)->toBe('Test Package')
        ->and($package->description)->toBe('Test Description')
        ->and($package->seat)->toBe(5)
        ->and($package->price_per_day)->toBe(1000.00);
});
