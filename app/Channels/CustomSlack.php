<?php


namespace App\Channels;

use Illuminate\Notifications\Notification;

class CustomSlack
{
    public function send($notifiable, Notification $notification)
    {
        $notification = $notification->toCustomSlack($notifiable);

        $notification->send();
        // Send notification to the $notifiable instance...
    }
}