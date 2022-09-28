<?php


namespace Modules\Linker\Services;



use GuzzleHttp\Client;

abstract class LinkerConfig
{
    protected Client $api;

    // public function __construct()
    // {
    //     $token = base64_encode(config('services.iugu.token'));
    //     $this->api = new Client([
    //         'headers' => [
    //             'Content-Type' => 'application/json',
    //             'Authorization' => "Basic $token"
    //         ],
    //         'base_uri' => 'https://oauth.linker.com.br'
    //     ]);
    // }
}
