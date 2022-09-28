<?php


namespace App\Services\Recebimento\Gatway\PjBank;


use GuzzleHttp\Client;

abstract class PjBankConfig
{
    /**
     * @var Client
     */
    protected $api;

    protected $credencial = '5f03410ff95f965531208e2c0521d111ca0458a7';

    /**
     * PjbankService constructor.
     */
    public function __construct()
    {
        $this->api = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'X-CHAVE-CONTA' => 'fadde17488ef85a13b03a5e39ca77bcccd383a7d'
//                'X-CHAVE' => 'e9db986de751de918ca19a1c377f0b7c313915f8'
            ],
//            'base_uri' => 'https://sandbox.pjbank.com.br'
            'base_uri' => 'https://api.pjbank.com.br/contadigital'
        ]);
    }
}