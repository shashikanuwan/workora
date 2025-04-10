<?php

use App\Models\Package;
use Workora\Package\Actions\DeletePackage;

it('can delete package', function () {
    $package = Package::factory()->create();

    resolve(DeletePackage::class)
        ->execute($package);

    expect(Package::query()->find($package->id))->toBeNull();
});
