<?php

namespace App\Listeners;

use App\Enums\Role;
use App\Events\BookingCanceled;
use App\Models\User;
use App\Notifications\BookingCanceledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendBookingCancellationNotification implements ShouldQueue
{
    public function __construct() {}

    public function handle(BookingCanceled $event): void
    {
        $booking = $event->booking;

        // Notify user
        $booking->user->notify(new BookingCanceledNotification($booking, false));

        // Notify all admins
        $admins = User::query()->role(Role::ADMIN->value)->get();
        Notification::send($admins, new BookingCanceledNotification($booking, true));
    }
}
