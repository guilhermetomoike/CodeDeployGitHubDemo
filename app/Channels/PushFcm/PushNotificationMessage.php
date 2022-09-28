<?php


namespace App\Channels\PushFcm;


class PushNotificationMessage
{
    public string $title;
    public string $body;
    public string $color = '#f45342';

    public static function create()
    {
        return new static();
    }

    public function setTitle(string $title): PushNotificationMessage
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(string $body): PushNotificationMessage
    {
        $this->body = $body;
        return $this;
    }

    public function setColor(string $color): PushNotificationMessage
    {
        $this->color = $color;
        return $this;
    }

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }
}
