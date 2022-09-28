<?php

namespace App\Services;

use GuzzleHttp\Client as Http;

class SlackService
{
    private $http;

    private $content = [];

    private $level = 'info';

    private $channels = [];

    public function __construct()
    {
        $token = config('services.slack.token');

        $config = [
            'base_uri' => 'https://slack.com/api/chat.postMessage',
            'headers' => [
                'Content-Type' => 'application/json; charset=utf-8',
                'Authorization' => "Bearer $token",
            ]
        ];

        $this->http = new Http($config);

        $this->content = [
            'fallback' => 'Notificação do Sistema',
            'pretext' => ':medal: ATENÇÃO :medal:',
            'fields' => []
        ];

    }

    public function setLevel(string $level)
    {
        $this->level = $level;
        return $this;
    }

    private function setColor(): void
    {
        switch ($this->level) {
            case 'success':
                $this->content['color'] = '#09814a';
                break;
            case 'error':
                $this->content['color'] = '#ff5042 ';
                break;
            case 'warning':
                $this->content['color'] = '#FFBF37';
                break;
            case 'info':
                $this->content['color'] = '#2EA6CC';
                break;
        }
    }

    public function text(string $text): SlackService
    {
        $this->content['fallback'] = $text;
        $this->content['pretext'] = $text;

        return $this;
    }

    /**
     * @param string | array $channel
     * @return SlackService
     */
    public function addChannel($channel): SlackService
    {
        if (is_array($channel)) {
            $this->channels = $channel;
        } else {
            $this->channels[] = $channel;
        }

        return $this;
    }

    public function addField(string $title, string $value, ?bool $short = true): SlackService
    {
        $this->content['fields'][] = [
            'title' => $title,
            'value' => $value,
            'short' => $short
        ];

        return $this;
    }

    public function send()
    {
        $this->setColor();

        if (config('app.env') !== 'production') {
            $data = json_encode([
                "channel" => '#teste',
                "attachments" => [$this->content],
            ]);
            $this->http->post('', ['body' => $data]);
            return;
        }

        foreach ($this->channels as $channel) {
            $data = json_encode([
                "channel" => $channel,
                "attachments" => [$this->content],
            ]);
            $this->http->post('', ['body' => $data]);
        }

    }
}
