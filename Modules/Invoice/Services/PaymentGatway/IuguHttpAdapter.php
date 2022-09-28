<?php


namespace Modules\Invoice\Services\PaymentGatway;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\Services\PaymentAdapter\IHttpAdapter;


class IuguHttpAdapter implements IHttpAdapter
{
    private Client $http;

    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    public function request(string $method, string $uri, array $data = []): array
    {
        try {
            $response = $this->http->request($method, $uri, ['json' => $data])->getBody()->getContents();
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();
        }
        return $this->handleResponse($response);
    }

    private function handleResponse(string $response)
    {
        $decoded_response = json_decode($response, true);

        if (isset($decoded_response['errors']) && is_array($decoded_response['errors'])) {
            array_walk($decoded_response['errors'], function (&$message, $error_key) {
                $string_message = is_array($message) ? implode(', ', $message) : $message;
                $message = strlen($error_key) > 1 ? $error_key . ' ' . $string_message : $string_message;
            });
        } else if (isset($decoded_response['errors']) && is_string($decoded_response['errors'])) {
            $decoded_response['errors'] = [$decoded_response['errors']];
        }

        return $decoded_response;
    }
}
