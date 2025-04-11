<?php

use App\Http\Controllers\Booking\CreateBookingController;
use App\Http\Controllers\Booking\ExtendBookingController;
use App\Http\Controllers\Booking\FetchAllBookingController;
use App\Http\Controllers\Booking\UpdateBookingStatusController;
use App\Http\Controllers\Package\CreatePackageController;
use App\Http\Controllers\Package\DeletePackageController;
use App\Http\Controllers\Package\FetchPackageController;
use App\Http\Controllers\Package\UpdatePackageController;
use App\Http\Controllers\User\FetchAuthenticateUserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->get('user', FetchAuthenticateUserController::class);

Route::middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {
        Route::get('packages', FetchPackageController::class);
        Route::post('packages', CreatePackageController::class);
        Route::put('packages/{package}', UpdatePackageController::class);
        Route::delete('packages/{package}', DeletePackageController::class);

        Route::get('bookings', FetchAllBookingController::class);
        Route::patch('bookings/{booking}/{status}', UpdateBookingStatusController::class)
            ->whereIn('status', ['confirm', 'cancel']);
        Route::post('booking-extend', ExtendBookingController::class);
    });

Route::middleware(['auth:sanctum', 'role:user'])
    ->group(function () {
        Route::post('bookings', CreateBookingController::class);
    });
