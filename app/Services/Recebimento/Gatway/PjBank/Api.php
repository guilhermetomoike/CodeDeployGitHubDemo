<?php

namespace App\Services\Recebimento\Gatway\PjBank;

use App\Models\Fatura;
use App\Models\TransacaoRecebimento;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class Api extends PjBankConfig
{

    public function criarTransacaoComToken(Array $data)
    {
        $data['parcelas'] = $data['parcelas'] ?? 1;

        try {
            $response = $this->api
                ->post("{$this->credencial}/recebimentos/transacoes", ['body' => json_encode($data)])
                ->getBody()
                ->getContents();

            $decodedResponse = json_decode($response);

            return $decodedResponse;

        } catch (\Throwable $throwable) {
            $response = $throwable->getMessage();
            throw new HttpException(400, $response);
        }
    }

    public function criarPrimeiraTransacaoComCartao(Array $data)
    {
        $data['valor'] = 1;
        $data['parcelas'] = 1;
        $data['descricao_pagamento'] = 'Teste primeira transação serviços medb';

        try {
            $response = $this->api
                ->post("{$this->credencial}/recebimentos/transacoes", ['body' => json_encode($data)])
                ->getBody()
                ->getContents();

            $decodedResponse = json_decode($response, true);

            $decodedResponse['valor_liquido'] = $decodedResponse['dados_parcela'][0]['valor_liquido'] ?? 0;
            $decodedResponse['valor'] = $decodedResponse['dados_parcela'][0]['valor'] ?? 0;
            $decodedResponse['descricao'] = $data['descricao_pagamento'];

            return $decodedResponse;

        } catch (\Throwable $throwable) {
            $response = $throwable->getMessage();
            throw new HttpException(400, "Erro inesperado ao gravar os dados. Tente novamente mais tarde. [{$response}]");
        }
    }

    public function cancelarTransacao(TransacaoRecebimento $transacao)
    {
        try {
            $response = $this->api
                ->delete("{$this->credencial}/recebimentos/transacoes/{$transacao->tid}")
                ->getBody()
                ->getContents();

            $decodedResponse = json_decode($response);

            return $decodedResponse;

        } catch (\Throwable $throwable) {
            $response = $throwable->getMessage();
            throw new HttpException(400, "Erro inesperado. [{$response}]");
        }
    }
}