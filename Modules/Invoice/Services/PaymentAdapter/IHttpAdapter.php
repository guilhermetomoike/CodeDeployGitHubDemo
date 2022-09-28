<?php


namespace Modules\Invoice\Services\PaymentAdapter;


interface IHttpAdapter
{
    public function request(string $method, string $uri, array $data = []): array;
}
