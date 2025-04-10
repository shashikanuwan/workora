<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Http\Requests\Package\CreateOrUpdatePackageRequest;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Workora\Package\Actions\CreateOrUpdatePackage;

class UpdatePackageController extends Controller
{
    public function __construct(protected CreateOrUpdatePackage $updatePackage) {}

    public function __invoke(CreateOrUpdatePackageRequest $request, Package $package): JsonResponse
    {
        $this->updatePackage->execute(
            $package,
            $request->validated('name'),
            $request->validated('description'),
            $request->validated('seat'),
            $request->validated('price_per_day'),
        );

        return response()->json([
            'status' => 'Package updated successfully',
        ], Response::HTTP_OK);
    }
}
