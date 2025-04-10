<?php

namespace Workora\Package\Actions;

use App\Models\Package;

class DeletePackage
{
    public function execute(Package $package): void
    {
        $package = Package::query()->find($package->id);
        $package->delete();
    }
}
