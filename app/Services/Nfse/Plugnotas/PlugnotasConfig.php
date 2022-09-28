<?php

namespace App\Services\Nfse\Plugnotas;

use GuzzleHttp\Client;

abstract class PlugnotasConfig
{
    /**
     * @var Client
     */
    protected $Http;

    /**
     * PjbankService constructor.
     */
    public function __construct()
    {
        $this->Http = new Client([
            'base_uri' => 'https://api.plugnotas.com.br',
            'headers' => [
                'Accept' => 'application/json',
                'x-api-key' => config('services.plugnotas.token')
            ]
        ]);
    }
}