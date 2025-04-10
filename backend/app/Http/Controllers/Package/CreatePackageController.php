<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Http\Requests\Package\CreateOrUpdatePackageRequest;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Workora\Package\Actions\CreateOrUpdatePackage;

class CreatePackageController extends Controller
{
    public function __construct(protected CreateOrUpdatePackage $createPackage) {}

    public function __invoke(CreateOrUpdatePackageRequest $request): JsonResponse
    {
        $this->createPackage->execute(
            new Package,
            $request->validated('name'),
            $request->validated('description'),
            $request->validated('seat'),
            $request->validated('price_per_day'),
        );

        return response()->json([
            'status' => 'Package created successfully',
        ], Response::HTTP_CREATED);
    }
}
