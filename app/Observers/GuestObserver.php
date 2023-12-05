<?php

namespace App\Observers;

use App\Models\Guest;
use App\Notifications\GuestNotification;

class GuestObserver
{
    public function created(Guest $guest)
    {
        $guest->notify(new GuestNotification($guest));
    }
}
