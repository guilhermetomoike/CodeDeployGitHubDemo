<?php

namespace App\Services\Recebimento\Gatway\PjBank;

use App\Models\CartaoCredito;
use App\Models\Fatura;
use App\Models\TransacaoRecebimento;
use App\Services\Recebimento\Contracts\RecebimentoCartao;
use App\Services\Recebimento\Contracts\Recebimento;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class PjbankService implements Recebimento, RecebimentoCartao
{
    /**
     * @var Api
     */
    private $Api;

    /**
     * PjbankService constructor.
     */
    public function __construct()
    {
        $this->Api = new class extends Api{};
    }

    public function tokenizar(Array $data)
    {
        // cria a primeira transacao de 1 real no cartao para validar os dados com as informacoes completas
        $response = $this->Api->criarPrimeiraTransacaoComCartao($data);

        // registra os dados da transacao
        $transacao = TransacaoRecebimento::create($response);

        // registra o token do cartao para futuras transacoes
        CartaoCredito::create([
            'token_cartao' => $response['token_cartao'],
            'cliente_id' => auth('api_clientes')->id(),
            'empresa_id' => $data['empresa_id'] ?? null,
            'vencimento' => "{$data['ano_vencimento']}-{$data['mes_vencimento']}-01"
        ]);

        // cancela a transacao realizada anteriormente para teste
        $this->cancelarTransacao($transacao);

    }

    public function cancelarTransacao(TransacaoRecebimento $transacao)
    {
        $response = $this->Api->cancelarTransacao($transacao);

        if ($response->status == 200) {
            $transacao->update([
                'status' => 'cancelada',
                'data_cancelamento' => $response->data_cancelamento,
                'msg' => $response->msg ?? null
            ]);
            return true;
        }

        throw new HttpException(400, $response->msg);
    }

    public function criarTransacao($valor, $descricao, $token_cartao)
    {
        $response = $this->Api->criarTransacaoComToken([
            "descricao_pagamento" => $descricao,
            "valor" => $valor,
            "parcelas" => 1,
            "token_cartao" => $token_cartao
        ]);

        return TransacaoRecebimento::create($response);
    }

}
