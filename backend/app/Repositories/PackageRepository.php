<?php

namespace App\Repositories;

use App\Models\Package;
use Illuminate\Pagination\LengthAwarePaginator;

class PackageRepository
{
    public function getAllPackages($perPage = 10): LengthAwarePaginator
    {
        return Package::query()
            ->paginate($perPage);
    }
}
