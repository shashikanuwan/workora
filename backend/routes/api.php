<?php

use App\Http\Controllers\Booking\CreateBookingController;
use App\Http\Controllers\Package\CreatePackageController;
use App\Http\Controllers\Package\DeletePackageController;
use App\Http\Controllers\Package\FetchPackageController;
use App\Http\Controllers\Package\UpdatePackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {
        Route::get('packages', FetchPackageController::class);
        Route::post('packages', CreatePackageController::class);
        Route::put('packages/{package}', UpdatePackageController::class);
        Route::delete('packages/{package}', DeletePackageController::class);

        Route::post('bookings', CreateBookingController::class);
    });
