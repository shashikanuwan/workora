<?php

namespace Workora\Package\Actions;

use App\Models\Package;

class UpdatePackage
{
    public function execute(
        Package $package,
        string $name,
        string $description,
        int $seat,
        float $pricePerDay,
    ): Package {
        $package = Package::query()->find($package->id);
        $package->name = $name;
        $package->description = $description;
        $package->seat = $seat;
        $package->price_per_day = $pricePerDay;
        $package->save();

        return $package;
    }
}
