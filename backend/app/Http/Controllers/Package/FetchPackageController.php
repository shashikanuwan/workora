<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Repositories\PackageRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FetchPackageController extends Controller
{
    public function __construct(protected PackageRepository $packageRepository) {}

    public function __invoke(): AnonymousResourceCollection
    {
        return PackageResource::collection($this->packageRepository->getAllPackages());
    }
}
