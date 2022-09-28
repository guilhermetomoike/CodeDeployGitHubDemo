<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use Modules\Invoice\Services\PaymentGatway\IuguHttpAdapter;
use Tests\TestCase;

class TestErrorResponseIuguApi extends TestCase
{
    public function testExample()
    {
        $service = new IuguHttpAdapter(new Client());

        $error1 = '{ "errors": { "due_date": [ "não pode ficar em branco", "não pode estar mais que três anos a frente", "não pode estar no passado" ] } }';
        $error2 = '{ "errors": [ "items deveria ser um Array" ] }';

        $reflector = new \ReflectionObject($service);
        $method = $reflector->getMethod('handleResponse');
        $method->setAccessible(true);
        $response = $method->invoke($service, $error2);

        dd($response);


    }
}
