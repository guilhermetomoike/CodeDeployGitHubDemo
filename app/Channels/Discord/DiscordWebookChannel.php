<?php


namespace App\Channels\Discord;


use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class DiscordWebookChannel
{
    public function send($notifiable, Notification $notification)
    {
        $notification = $notification->toCustomDiscord($notifiable);

        $this->create($notification);
    }

    private function create($notification)
    {
        $client = Http::asJson()
            ->baseUrl('https://discordapp.com/api/webhooks/');

        $data = [
            'content' => $notification->content,
            "username" => $notification->username,
            "tts" => $notification->tts,
        ];

        foreach ($notification->channels as $channel) {
            $client->post($channel, $data);
        }

    }

    public static function staticSend(DiscordMessage $message)
    {
        (new static())->create($message);
    }
}
