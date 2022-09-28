<?php

namespace Modules\Invoice\Repositories;

use Carbon\Carbon;
use Modules\Invoice\Entities\ContasReceber;
use function GuzzleHttp\Promise\queue;

class ContasReceberRepository
{
    private MovimentoContasReceberRepository $movimentoContasReceberRepository;

    public function __construct(MovimentoContasReceberRepository $movimentoContasReceberRepository)
    {
        $this->movimentoContasReceberRepository = $movimentoContasReceberRepository;
    }

    public function getContasReceber(array $params = [])
    {
        return ContasReceber::query()
            ->with('payer')
            ->when(!empty($params['mes']), function ($query, $value) use ($params) {
                $query->whereMonth('vencimento', Carbon::parse($params['mes'])->month);
                $query->whereYear('vencimento', Carbon::parse($params['mes'])->year);
            })
            ->get();
    }

    public function getContasReceberById($id)
    {
        return ContasReceber::query()
            ->with('payer', 'movimento')
            ->find($id);
    }

    public function createContasReceber(array $data)
    {
        $conta = new ContasReceber;
        $conta->vencimento = $data['vencimento'];
        $conta->valor = $data['valor'];
        $conta->descricao = $data['descricao'];
        $conta->payer_type = $data['payer_type'];
        $conta->payer_id = $data['payer_id'];
        $conta->save();

        $this->movimentoContasReceberRepository->create(
            $conta->id,
            $conta->valor,
            'Lançamento de ' . $conta->descricao
        );

        return $conta;
    }

    public function changeValue(int $contaReceberId, float $newValue)
    {
        $conta = ContasReceber::query()->find($contaReceberId);
        $conta->valor = $newValue;
        return $conta->save();
    }
}
