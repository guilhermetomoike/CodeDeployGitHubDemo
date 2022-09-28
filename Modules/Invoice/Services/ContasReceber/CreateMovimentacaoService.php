<?php

namespace Modules\Invoice\Services\ContasReceber;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\Repositories\ContasReceberRepository;
use Modules\Invoice\Repositories\MovimentoContasReceberRepository;

class CreateMovimentacaoService
{
    private MovimentoContasReceberRepository $movimentoContasReceberRepository;
    private ContasReceberRepository $contasReceberRepository;

    public function __construct(
        MovimentoContasReceberRepository $movimentoContasReceberRepository,
        ContasReceberRepository $contasReceberRepository
    ) {
        $this->movimentoContasReceberRepository = $movimentoContasReceberRepository;
        $this->contasReceberRepository = $contasReceberRepository;
    }

    public function createMoviment(array $data)
    {
        try {
            DB::beginTransaction();
            $conta = $this->contasReceberRepository->getContasReceberById($data['contaReceberId']);

            if (($conta->valor + $data['valor']) < 0) {
                throw new \Exception('O desconto não pode exceder o valor do saldo');
            }

            $movement = $this->movimentoContasReceberRepository->create(
                $data['contaReceberId'],
                $data['valor'],
                $data['descricao']
            );

            $this->contasReceberRepository->changeValue($data['contaReceberId'], ($conta->valor + $data['valor']));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }

        return $movement;
    }


    public function createMovimentAddicionais(array $data)
    {

        try {
            DB::beginTransaction();
            $conta = $this->contasReceberRepository->getContasReceberById($data['contaReceberId']);
            $movement = '';
            if (($data['valor']) <= 0) {
                throw new \Exception('Adicional Sem Valor');
            }
            $movimento =  DB::table('movimento_contas_receber')->where('contas_receber_id', $data['contaReceberId'])->where('descricao', $data['descricao'])->first();
            if (!isset($movimento->id)) {
                $movement = $this->movimentoContasReceberRepository->create(
                    $data['contaReceberId'],
                    $data['valor'],
                    $data['descricao']
                );
            }
            $this->contasReceberRepository->changeValue($data['contaReceberId'], ($conta->valor + $data['valor']));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }

        return $movement;
    }
}
