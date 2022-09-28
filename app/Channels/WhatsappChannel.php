<?php


namespace App\Channels;

use App\Models\NotifiableContract;
use App\Services\TwilioService;
use Illuminate\Notifications\Notification;

class WhatsappChannel
{
    public function send(NotifiableContract $notifiable, Notification $notification)
    {
        $message = $notification->toWhatsapp($notifiable);

        $recipient = !$message->recipient ? $notifiable->routeNotificationForWhatsApp() : $message->recipient;

        (new TwilioService())->send($recipient, $message->message, $message->media);
    }
}