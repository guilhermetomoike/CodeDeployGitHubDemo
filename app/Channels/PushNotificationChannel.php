<?php


namespace App\Channels;


use App\Models\NotifiablePushNotificationContract;
use Illuminate\Notifications\Notification;

class PushNotificationChannel
{
    public function send(NotifiablePushNotificationContract $notifiable, Notification $notification)
    {
        $notification->toFcm($notifiable);
    }
}
