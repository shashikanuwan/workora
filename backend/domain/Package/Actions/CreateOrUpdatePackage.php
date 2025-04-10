<?php

namespace Workora\Package\Actions;

use App\Models\Package;

class CreateOrUpdatePackage
{
    public function execute(
        Package $package,
        string $name,
        string $description,
        int $seat,
        float $pricePerDay,
    ): Package {
        $package->name = $name;
        $package->description = $description;
        $package->seat = $seat;
        $package->price_per_day = $pricePerDay;
        $package->save();

        return $package;
    }
}
