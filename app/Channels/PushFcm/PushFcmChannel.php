<?php


namespace App\Channels\PushFcm;


use App\Models\NotifiablePushNotificationContract;
use App\Services\Aplicativo\PushNotificationService;
use Illuminate\Notifications\Notification;

class PushFcmChannel
{
    public function send(NotifiablePushNotificationContract $notifiable, Notification $notification)
    {
        $pushNotificationMessage = $notification->toPushFcm($notifiable);

        (new PushNotificationService())
            ->setDeviceId($notifiable->routeNotificationForFcm())
            ->setNotification($pushNotificationMessage)
            ->sendPushNotification();
    }
}
