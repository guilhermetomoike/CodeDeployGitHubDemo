<?php


namespace App\Services\Recebimento\Gatway\Iugu;


use GuzzleHttp\Client;

abstract class IuguConfig
{
    protected Client $api;

    public function __construct()
    {
        $token = base64_encode(config('services.iugu.token'));
        $this->api = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Basic $token"
            ],
            'base_uri' => 'https://api.iugu.com/v1/'
        ]);
    }
}
