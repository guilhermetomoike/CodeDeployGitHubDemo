<?php

namespace Modules\Invoice\Services;

use App\Services\GuiaService;
use App\Services\Recebimento\Gatway\Asas\AsasService;
use App\Services\Recebimento\Gatway\Asas\Common\AsasCliente;
use App\Services\Recebimento\Gatway\Asas\Common\AsasFatura;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\Entities\ContasReceber;
use Modules\Invoice\Jobs\CreateContasReceberJob;
use Modules\Invoice\Jobs\FaturaToHonorarioAsasJob;
use Modules\Invoice\Jobs\FaturaToHonorarioJob;

class CreateInvoiceCreditoServiceAsas
{
    private AsasService $asasService;
    private GuiaService $guiaService;

    public function __construct(AsasService $asasService, GuiaService $guiaService)
    {
        $this->asasService = $asasService;
        $this->guiaService = $guiaService;
    }

    public function execute(ContasReceber $contasReceber)
    {
        $payer = $contasReceber->payer;
        $competencia = Carbon::parse($contasReceber->vencimento)->subMonth()->format('Y-m-01');
        $hasCreditCard = $payer->cartao_credito->count();

        // return $contasReceber;

        try {
            DB::beginTransaction();
            if ($hasCreditCard) {
                if (!$payer->pay_cont_id) {
                    $contasReceber->payer = $this->asasService->criarCliente($payer);
                }

                $fatura = $this->criarFaturaModel($contasReceber, $contasReceber->vencimento, 2);

                $asasObject = $this->makeAsasInvoiceObject($contasReceber, $fatura->data_vencimento, $fatura);



                // return  response()->json($asasObject->items[0]->price_cents);
                // return  response()->json($asasObject,200);
                $response = $this->asasService->criarFatura($asasObject);
                $fatura->gatway_fatura_id = $response->id;
                $fatura->fatura_url = $response->invoiceUrl;
                $fatura->fatura_url_boleto = $response->transactionReceiptUrl;

                $fatura->save();
    
             
                FaturaToHonorarioAsasJob::dispatch($fatura->fresh(), 1);


                unset($contasReceber->payer);
                $contasReceber->consumed_at = today();
                $contasReceber->save();

                // $this->guiaService->changeLiberacao(['financeiro_departamento_liberacao' => true], $fatura->payer_id, $competencia);
                // CreateContasReceberJob::dispatch($payer, true);
             DB::commit();

                return $fatura;
            } else {
                return 'boleto ';
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
            'data_competencia' => Carbon::parse($competencia)->subMonth()->format('Y-m-01'),
            'payer_type' => $contaReceber->payer->getModelAlias(),
            'data_vencimento' => Carbon::now() >= Carbon::parse($competencia)->format('Y-m-20') ?  Carbon::now() : Carbon::parse($contaReceber->data_vencimento)->format('Y-m-d') ,
            'status' => 'pendente',
            'subtotal' => $contaReceber->valor,
            'forma_pagamento_id' => $paymentMethodId,
            'conta_receber_id' => $contaReceber->id
        ]);

        return $fatura;
    }

    private function makeAsasInvoiceObject($contaReceber, $dataVencimento, $fatura)
    {
        $totalValor = 0;

        $faturaAsas = new AsasFatura;
        $faturaAsas->setCustomer($contaReceber->payer->pay_cont_id ?? 'teste');
        $faturaAsas->setDueDate($dataVencimento);
        $faturaAsas->setExternalReference($fatura->id);
        $texto = '';
        foreach ($contaReceber->movimento as $mov) {
            if ($texto == '') {
                $texto = $mov->descricao;
            } else {
                $texto =  $texto . ', ' . $mov->descricao;
            }
            if ($mov->valor > 0) {
                $totalValor = $mov->valor + $totalValor;
            }
        }


        $cartao_credito  = (object) $contaReceber->payer->cartao_credito[$contaReceber->payer->cartao_credito->count() - 1];


        if ($cartao_credito->token_cartao == null) {

            $payable = new AsasCliente($contaReceber->payer);
            $payable =       $payable->toArray();


            $faturaAsas->setCreditCardHolderInfo(
                [
                    'name'  => $payable['name'],
                    'email'  => $payable['email'],
                    'cpfCnpj'  => $payable['cpfCnpj'],
                    'postalCode'  => $payable['postalCode'],
                    'addressNumber'  => $payable['addressNumber'],
                    'addressComplement'  => empty($payable['complement']) ? 'sem complemento': $payable['complement'],
                    'phone'  => $payable['phone'][0],
                    'mobilePhone'  => $payable['mobilePhone'][0],

                ]
            );

            $faturaAsas->setCreditCard(
                [
                    'holderName'  => $cartao_credito->dono_cartao,
                    'number'  => $cartao_credito->numero,
                    'expiryMonth'  => $cartao_credito->mes,
                    'expiryYear'  => strval($cartao_credito->ano),
                    'ccv'  => $cartao_credito->cvc


                ]
            );
        }
        else{
            $faturaAsas->setCreditCardToken($cartao_credito->token_cartao);
        }
        $faturaAsas->setValue($totalValor);
        $faturaAsas->setBillingType('CREDIT_CARD');
        $faturaAsas->setDescription($texto);
        $faturaAsas->setDiscountFromMovimentoContasReceber($contaReceber->movimento);

       


        return $faturaAsas;
    }
}
