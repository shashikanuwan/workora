<?php

namespace Workora\Package\Actions;

use App\Models\Package;

class CreatePackage
{
    public function execute(
        string $name,
        string $description,
        int $seat,
        float $pricePerDay,
    ): Package {
        $package = new Package;
        $package->name = $name;
        $package->description = $description;
        $package->seat = $seat;
        $package->price_per_day = $pricePerDay;
        $package->save();

        return $package;
    }
}
