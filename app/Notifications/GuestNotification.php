<?php

namespace App\Notifications;

use App\Models\Guest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\AfricasTalking\AfricasTalkingChannel;
use NotificationChannels\AfricasTalking\AfricasTalkingMessage;

class GuestNotification extends Notification
{
    use Queueable;

    public $guest;

    public function __construct(Guest $guest)
    {
        $this->guest = $guest;
    }

    public function via($notifiable): array
    {
        return [AfricasTalkingChannel::class];
    }

    public function toAfricasTalking($notifiable)
    {
        return (new AfricasTalkingMessage())
            ->content("Dear" .$this->guest->name." The Ben & Pamella invite you to our traditional wedding on Dec 15 2023 at Jalia Garden at 14h00. Your presence would make this day more special. You'll use this code ".$this->guest->invitation_code.' for checkin.')
            ->to($this->guest->phone_number);
    }
}
