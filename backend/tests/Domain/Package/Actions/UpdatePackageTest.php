<?php

use App\Models\Package;
use Workora\Package\Actions\UpdatePackage;

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

    expect($updatedPackage)->toBeInstanceOf(Package::class)
        ->and($updatedPackage->name)->toBe('Updated Package')
        ->and($updatedPackage->description)->toBe('Updated Description')
        ->and($updatedPackage->seat)->toBe(10)
        ->and($updatedPackage->price_per_day)->toBe(2000.00);
});
