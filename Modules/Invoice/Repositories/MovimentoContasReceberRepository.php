<?php

namespace Modules\Invoice\Repositories;

use Modules\Invoice\Entities\MovimentoContasReceber;

class MovimentoContasReceberRepository
{
    public function create(int $contaReceberId, float $valor, string $descricao)
    {
        $movimentacao = new MovimentoContasReceber();
        $movimentacao->contas_receber_id = $contaReceberId;
        $movimentacao->valor = $valor;
        $movimentacao->descricao = $descricao;
        $movimentacao->save();
        return $movimentacao;
    }
}
