<?php

namespace App\Services;

use GuzzleHttp\Client;

class ClicksignApiService extends Service
{
    private $baseUrl;

    private $accessToken;

    private $client;

    public function __construct(string $accessToken, string $env = 'local')
    {
        $this->accessToken = $accessToken;

        $this->baseUrl = ($env == 'production')
            ? 'https://app.clicksign.com'
            : 'https://sandbox.clicksign.com'
        ;

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'access_token' => $this->accessToken,
            ],
        ]);
    }

    public function createDocument(array $data)
    {
        return $this->request('POST', '/documents', [
            'json' => ['document' => $data],
        ]);
    }

    public function getDocument(string $document_key)
    {
        return $this->request('GET', '/documents/'.$document_key);
    }

    public function createSigner(array $data)
    {
        return $this->request('POST', '/signers', [
            'json' => ['signer' => $data],
        ]);
    }

    public function createList(array $data)
    {
        return $this->request('POST', '/lists', [
            'json' => ['list' => $data],
        ]);
    }

    public function createBatch(array $data)
    {
        return $this->request('POST', '/batches', [
            'json' => ['batch' => $data],
        ]);
    }

    private function request(string $method, string $endpoint, array $options = [])
    {
        return json_decode($this->client->request($method, "/api/v1{$endpoint}", $options)->getBody(), true);
    }
}
