<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Workora\Package\Actions\DeletePackage;

class DeletePackageController extends Controller
{
    public function __construct(protected DeletePackage $deletePackage) {}

    public function __invoke(Package $package): JsonResponse
    {
        $this->deletePackage->execute($package);

        return response()->json([
            'message' => 'Package deleted successfully',
        ], Response::HTTP_OK);
    }
}
