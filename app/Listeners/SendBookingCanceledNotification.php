<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\BookingCanceled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingCanceledNotification;

class SendBookingCanceledNotification implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(BookingCanceled $event): void
    {
        $staffMembers = User::where('role', 'staff')->get();

        Notification::send($staffMembers, new BookingCanceledNotification($event->booking));
    }
}

