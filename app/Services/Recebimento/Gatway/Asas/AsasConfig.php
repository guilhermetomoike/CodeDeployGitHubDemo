<?php


namespace App\Services\Recebimento\Gatway\Asas;


use GuzzleHttp\Client;

abstract class AsasConfig
{
    protected Client $api;

    public function __construct()
    {
        
        $token = config('services.asas.token');
        $this->api = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' =>  $token
            ],
            'base_uri' => 'https://www.asaas.com/api/v3/'
        ]);
    }
}
