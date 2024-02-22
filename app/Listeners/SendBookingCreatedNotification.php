<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\BookingCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingCreatedNotification;

class SendBookingCreatedNotification
{

    public function __construct()
    {
        //
    }

    public function handle(BookingCreated $event)
    {
        $staffMembers = User::where('role', 'staff')->get();

        Notification::send($staffMembers, new BookingCreatedNotification($event->booking));
    }
}
