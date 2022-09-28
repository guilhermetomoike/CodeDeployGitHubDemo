<?php

namespace Modules\Invoice\Services;

use App\Services\GuiaService;
use App\Services\Recebimento\Gatway\Iugu\Common\IuguFatura;
use App\Services\Recebimento\Gatway\Iugu\IuguService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\Entities\ContasReceber;
use Modules\Invoice\Jobs\CreateContasReceberJob;
use Modules\Invoice\Jobs\FaturaToHonorarioJob;

class CreateInvoiceService
{
    private IuguService $iuguService;
    private GuiaService $guiaService;

    public function __construct(IuguService $iuguService, GuiaService $guiaService)
    {
        $this->iuguService = $iuguService;
        $this->guiaService = $guiaService;
    }

    public function execute(ContasReceber $contasReceber)
    {
        $payer = $contasReceber->payer;
        $competencia = Carbon::parse($contasReceber->vencimento)->subMonth()->format('Y-m-01');
        $hasCreditCard = $payer->cartao_credito->count();

// return $contasReceber;

        try {
            // DB::beginTransaction();
            if ($hasCreditCard) {
            if (!$contasReceber->iugu_id) {
                $contasReceber->payer = $this->iuguService->criarCliente($payer);
            }

            $fatura = $this->criarFaturaModel($contasReceber, $competencia, $hasCreditCard ? 2 : 1);

  
            $iuguObject = $this->makeIuguInvoiceObject($contasReceber, $fatura->data_vencimento,$fatura);
      

            // return  response()->json($iuguObject->items[0]->price_cents);
            // return  response()->json($iuguObject,200);
            $response = $this->iuguService->criarFatura($iuguObject);
            $fatura->gatway_fatura_id = $response->id;
            $fatura->fatura_url = $response->secure_url;
            $fatura->pix_qrcode_text = $response->pix->qrcode_text ?? null;
            $fatura->save();



          
                // FaturaToHonorarioJob::dispatch($fatura->fresh(), "HONORARIOS");
                // $this->iuguService->downloadPdf($fatura->fresh());
                // $this->guiaService->createOrUpdateHonorario($fatura);
      
          

            unset($contasReceber->payer);
            $contasReceber->consumed_at = today();
            $contasReceber->save();

            // $this->guiaService->changeLiberacao(['financeiro_departamento_liberacao' => true], $fatura->payer_id, $competencia);
            CreateContasReceberJob::dispatch($payer, true);
            // DB::commit();
            return $fatura;
        }

        } catch (\Exception $exception) {
            return 'Erro fatura: ' . $payer->id . json_encode([$exception->getMessage()]);
            Log::channel('stack')->info('Erro fatura: ' . $payer->id . json_encode([$exception->getMessage()]));
            DB::rollBack();
            return;
        }
    }

    private function criarFaturaModel($contaReceber, string $competencia, $paymentMethodId)
    {
       

        $fatura = $contaReceber->payer->fatura()->create([
            'data_competencia' => $competencia,
             'payer_type'=> $contaReceber->payer->getModelAlias(),       
            'data_vencimento' => date('Y-m-20', strtotime($competencia . ' + 1 month')),
            'status' => 'pendente',
            'subtotal' => $contaReceber->valor,
            'forma_pagamento_id' => $paymentMethodId
        ]);

        return $fatura;
    }

    private function makeIuguInvoiceObject($contaReceber, $dataVencimento)
    {

        $faturaIugu = new IuguFatura;
        $faturaIugu->setCustomerId($contaReceber->payer->iugu_id ?? 'teste');
        $faturaIugu->setDueDate($dataVencimento);
        $faturaIugu->setEmail($contaReceber->payer->contatos()->email());
        $faturaIugu->setItemsFromMovimentoContasReceber($contaReceber->movimento);

        return $faturaIugu;
    }
}
