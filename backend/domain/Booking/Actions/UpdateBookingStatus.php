<?php

namespace Workora\Booking\Actions;

use App\Enums\BookingStatus;
use App\Events\BookingCanceled;
use App\Events\BookingConfirmed;
use App\Exceptions\BookingAlreadyCanceledException;
use App\Exceptions\BookingAlreadyConfirmedException;
use App\Exceptions\CanceledBookingCannotBeConfirmedException;
use App\Exceptions\ConfirmedBookingCannotBeCanceledException;
use App\Models\Booking;

class UpdateBookingStatus
{
    public function execute(
        Booking $booking,
        BookingStatus $status,
    ): Booking {
        $this->ensureBookingCanBeUpdated($booking, $status);

        $booking->status = $status;
        $booking->save();

        if ($status === BookingStatus::CONFIRMED) {
            BookingConfirmed::dispatch($booking);
        }
        if ($status === BookingStatus::CANCELED) {
            BookingCanceled::dispatch($booking);
        }

        return $booking;
    }

    private function ensureBookingCanBeUpdated(Booking $booking, BookingStatus $newStatus): void
    {
        $currentStatus = $booking->status;

        $statusTransitions = [
            [BookingStatus::CONFIRMED, BookingStatus::CONFIRMED, BookingAlreadyConfirmedException::class],
            [BookingStatus::CANCELED, BookingStatus::CANCELED, BookingAlreadyCanceledException::class],
            [BookingStatus::CANCELED, BookingStatus::CONFIRMED, CanceledBookingCannotBeConfirmedException::class],
            [BookingStatus::CONFIRMED, BookingStatus::CANCELED, ConfirmedBookingCannotBeCanceledException::class],
        ];

        foreach ($statusTransitions as [$from, $to, $exception]) {
            if ($currentStatus === $from && $newStatus === $to) {
                throw new $exception;
            }
        }
    }
}
