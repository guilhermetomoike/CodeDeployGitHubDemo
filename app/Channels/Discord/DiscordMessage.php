<?php


namespace App\Channels\Discord;


class DiscordMessage
{
    public string $content;
    public array $channels = [];
    public string $username = 'Medbot';
    public bool $tts = false;

    public static function create(): DiscordMessage
    {
        return new self();
    }

    public function setUsername(string $username): DiscordMessage
    {
        $this->username = $username;
        return $this;
    }

    public function setContent(string $content): DiscordMessage
    {
        $this->content = $content;
        return $this;
    }

    public function addChannel(string $channel): DiscordMessage
    {
        $this->channels[] = $channel;
        return $this;
    }

    public function setTts(bool $tts): DiscordMessage
    {
        $this->tts = $tts;
        return $this;
    }


}
