<?php


namespace App\Services\Recebimento\Contracts;


use App\Models\Fatura;
use App\Models\TransacaoRecebimento;

interface RecebimentoCartao
{
    /**
     * Envia os dados do cartao e do titular do cartao para api gerar um token
     * @param $array
     * @return mixed
     */
    public function tokenizar(Array $array);

    /**
     * Recebe uma Fatura e tenta criar uma transacao utilizando o token do cartao do responsavel da empresa
     *
     * @param $valor
     * @param $descricao
     * @param $token
     * @return mixed
     */
    public function criarTransacao($valor, $descricao, $token);

    /**
     * @param $transacao
     * @return mixed
     */
    public function cancelarTransacao(TransacaoRecebimento $transacao);
}
