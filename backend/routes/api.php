<?php

use App\Http\Controllers\Package\CreatePackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {
        Route::post('packages', CreatePackageController::class);
    });
