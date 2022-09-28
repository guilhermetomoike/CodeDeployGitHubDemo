<?php

namespace App\Infrastructure\Guzzle;

use GuzzleHttp\Client;

class Guzzle
{
    protected $url;

    protected $timeout = 30.0;

    protected $client;

    public function setUrl(string $url): Guzzle
    {
        $this->url = $url;
        return $this;
    }

    public function setTimeout(float $timeout): Guzzle
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function call(): Guzzle
    {
        if (empty($this->client)) {
            $this->setClient();
        }
        return $this;
    }

    public function setClient(array $headers = []): Guzzle
    {
        $headersBase = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $this->client = new Client([
            'timeout' => $this->timeout,
            'base_uri' => $this->url,
            'headers' => array_merge($headersBase, $headers),
        ]);

        return $this;
    }
}
