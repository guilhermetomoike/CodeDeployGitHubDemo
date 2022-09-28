<?php

namespace App\Services\Recebimento\Gatway\Asas;

use App\Jobs\CreateIuguPaymentMethodJob;
use App\Models\Contrato;
use App\Models\Empresa;
use App\Models\Payer\PayerContract;
use App\Repositories\CartaoCreditoRepository;
use App\Services\Recebimento\Contracts\Recebimento;
use App\Services\Recebimento\Gatway\Asas\Common\AsasCliente;
use App\Services\Recebimento\Gatway\Asas\Common\AsasFatura;
use Illuminate\Support\Collection;
use Modules\Invoice\Entities\Fatura;

class AsasService implements Recebimento
{
    private $Api;
    private $CartaoCreditoRepository;

    public function __construct()
    {
        $this->Api = new ApiAsas();
        $this->CartaoCreditoRepository = new CartaoCreditoRepository();
    }

    public function storeToken(array $data)
    {
        $cartao_credito = $this->CartaoCreditoRepository->storeToken($data);

        if (isset($data['empresa_id']) && !empty($data['empresa_id'])) {
            CreateIuguPaymentMethodJob::dispatch();
        }

        return $cartao_credito;
    }

    public function criarCliente(PayerContract $payer)
    {
        $asas_cliente = $this->Api->cadastrarCliente($payer);
        $payer->update(['pay_cont_id' => $asas_cliente->id]);
        return $payer;
    }

    public function criarCobrancaDireta(array $request)
    {
        $empresa = Empresa::find($request['empresa_id']);
        if (!$empresa->pay_cont_id) {
            $empresa = $this->criarCliente($empresa);
        }
        $response = $this->Api->receber($empresa, $request['token_cartao'], $request['valor'], $request['descricao'] ?? null);
        if ($response->success) {
            $empresa->transacao_recebimento()->create([
                'valor' => $request['valor'],
                'status' => 'autorizada',
                'descricao' => $request['descricao'] ?? 'cobranca direta',
                'response' => $response,
            ]);
            $empresa->fatura()->where('status', 'atrasado')->update(['status' => 'pago']);
        }
        return $response;
    }

    /**
     * cadastra na api do iugu uma forma de paamento vinculada ao pagador
     * @param PayerContract $payer
     * @return mixed
     */
    public function criarFormaPagamento(PayerContract $payer)
    {
        if (!$payer->pay_cont_id) {
            $payer = $this->criarCliente($payer);
        }

        $cartao_credito = $payer->cartao_credito;
        if (!$cartao_credito || ($cartao_credito && !$cartao_credito->token_cartao)) {
            return false;
        }
        try {
            $response = $this->Api->criarFormaPagamento($payer->pay_cont_id, $cartao_credito->token_cartao);
        } catch (\Exception$e) {
            $erro = json_decode($e->getMessage());
            if ($erro->errors && $erro->errors->token && $erro->errors->token[0] == 'Esse token já foi usado.') {
                $cartao_credito->delete();
            }
            abort(400, json_encode($erro));
        }

        $cartao_credito->used = true;
        $cartao_credito->save();

        return $payer->contrato()->updateOrCreate([
            'empresas_id' => $payer->id,
        ], [
            'forma_pagamento_gatway_id' => $response->id,
            'forma_pagamento_gatway_data' => $response->data,
        ]);
    }

    public function criarFatura(AsasFatura $faturaObject)
    {
        // return  $faturaObject;
        return $this->Api->criarFatura($faturaObject);
    }
    public function updateFatura(AsasFatura $faturaObject, $gatway_fatura_id)
    {
        // return  $faturaObject;
        return $this->Api->updateFatura($faturaObject, $gatway_fatura_id);
    }
    public function listaFaturasAtrasadas()
    {
        // return  $faturaObject;
        return $this->Api->listaFaturasAtrasadas();
    }

    public function criarFaturaWithItems(Fatura $fatura): Fatura
    {
        $hasCreditCard = $fatura->payer->cartao_credito->count();
        if (!$hasCreditCard) {
            $faturaAsas = $this->objectAsasFatura($fatura);
        } else {
            $faturaAsas = $this->objectAsasCartaoFatura($fatura);

        }

        $response = $this->criarFatura($faturaAsas);
        
        $fatura->gatway_fatura_id = $response->id;
        $fatura->fatura_url = $response->invoiceUrl;
        if (!$hasCreditCard) {
            $fatura->fatura_url_boleto = $response->bankSlipUrl;

        } else {
            $fatura->fatura_url_boleto = $response->transactionReceiptUrl;
        }

        $fatura->save();

        return $fatura;
    }

    public function criarFaturaAtrasadasWithItems(Fatura $fatura)
    {
        $hasCreditCard = $fatura->payer->cartao_credito->count();
        if (!$hasCreditCard) {
            $faturaAsas = $this->objectAsasFatura($fatura);
        } else {
            $faturaAsas = $this->objectAsasCartaoFatura($fatura);

        }

        $response = $this->criarFatura($faturaAsas);
        
        $fatura->gatway_fatura_id = $response->id;
        $fatura->fatura_url = $response->invoiceUrl;
        if (!$hasCreditCard) {
            $fatura->fatura_url_boleto = $response->bankSlipUrl;

        } else {
            $fatura->fatura_url_boleto = $response->transactionReceiptUrl;
        }


        return $response;
    }
    public function updateFaturaWithItems(Fatura $fatura): Fatura
    {

        $faturaAsas = $this->objectAsasFatura($fatura);
        $response = $this->updateFatura($faturaAsas, $fatura->gatway_fatura_id);

        $fatura->save();

        return $fatura;
    }

    private function qualifyChargeablePlans(?Collection $subscribedPlans, ?Contrato $contrato): Collection
    {
        $subscribedPlans = collect([])->add(
            (new PaymentSubItem())
                ->setPriceCents($contrato->teto_cobranca)
                ->setDescription('Honorários')
                ->setRecurrent(true)
        );

        return $subscribedPlans;
    }

    private function qualifyFaturaItems(Fatura $fatura, ?Contrato $contrato): Collection
    {
        $itemsFaturaIugu = collect([])->add(
            (new PaymentSubItem())
                ->setPriceCents($fatura->subtotal)
                ->setDescription('Honorários')
        );

        return $itemsFaturaIugu;
    }

    public function cancelarFatura(Fatura $fatura)
    {

        abort_if($fatura->status === 'pago', 400, 'Não é possível cancelar uma fatura Paga por boleto.');
        $this->Api->cancelarFatura($fatura->gatway_fatura_id);

        return $fatura->update(['status' => 'cancelado']);

        $fatura->update(['status' => 'cancelado']);
        $payer = $fatura->payer;

        if ($payer instanceof Empresa) {
            $this->reverseFromTaxes($payer, $fatura);
        }

        return $fatura;
    }

    private function reverseFromTaxes(Empresa $payer, $fatura)
    {
        $guia = $payer
            ->guias()
            ->firstWhere(['data_competencia' => $fatura->data_competencia, 'tipo' => 'HONORARIOS']);

        if ($guia) {
            $guia->delete();
        }
    }

    public function reembolsarFatura(Fatura $fatura)
    {
        abort_if($fatura->status !== 'pago', 400, 'Não é possível estornar uma fatura não Paga.');
        $this->Api->reembolsarFatura($fatura->gatway_fatura_id);
        return $fatura->update(['status' => 'estornado']);
    }

    private function resolveDesconto(Collection &$collectionIuguItem, ?Contrato $contrato)
    {
        if (!$contrato || !$contrato->teto_cobranca) {
            return;
        }
        $total = $collectionIuguItem->sum(function ($item) {
            return ($item->price_cents / 100) * $item->quantity;
        });
        if ($total < $contrato->teto_cobranca) {
            return;
        }
        $desconto = new PaymentSubItem();
        $desconto->setRecurrent(true);
        $desconto->setDescription('Desconto');
        $desconto->setPriceCents($contrato->teto_cobranca - $total);
        $collectionIuguItem->add($desconto);
    }

    public function downloadPdf(Fatura $fatura)
    {
        $nome_arquivo = $this->Api->downloadPdf($fatura);
        return $fatura->arquivo()->create([
            'nome_original' => $nome_arquivo,
            'caminho' => $nome_arquivo,
            'tags' => [
                'fatura_id' => $fatura->id,
                $fatura->payer_type => $fatura->payer_id,
            ],
        ]);
    }

    public function objectAsasFatura($fatura)
    {
        $payer = $fatura->payer;
        if (!$payer->pay_cont_id) {
            $payer = $this->criarCliente($payer);
        }

        $totalValor = 0;

        $faturaAsas = new AsasFatura;
        $faturaAsas->setCustomer($payer->pay_cont_id ?? 'teste');
        $faturaAsas->setDueDate($fatura->data_vencimento);
        $faturaAsas->setExternalReference($fatura->id);
        $texto = '';
        if (isset($fatura->movimento[0]['id'])) {

            foreach ($fatura->movimento as $item) {
                if ($texto == '') {
                    $texto = $item->descricao ?? ' ';
                } else {
                    $texto = $texto . ' + ' . $item->descricao;
                }
                if ($item->valor > 0) {
                    $totalValor = $item->valor + $totalValor;
                }
            }
            $faturaAsas->setDiscountFromMovimentoContasReceber($fatura->movimento);

        } else {

            foreach ($fatura->items as $item) {
                if ($texto == '') {
                    $texto = $item->descricao ?? ' ';
                } else {
                    $texto = $texto . ' + ' . $item->descricao;
                }
                if ($item->valor > 0) {
                    $totalValor = $item->valor + $totalValor;
                }
            }
            $faturaAsas->setDiscountFromMovimentoContasReceber($fatura->items);

        }

        $faturaAsas->setValue($totalValor);
        $faturaAsas->setBillingType('BOLETO');
        $faturaAsas->setDescription($texto);

        return $faturaAsas;
    }

    public function objectAsasCartaoFatura($fatura)
    {
        $payer = $fatura->payer;
        if (!$payer->pay_cont_id) {
            $payer = $this->criarCliente($payer);
        }

        $totalValor = 0;

        $faturaAsas = new AsasFatura;
        $faturaAsas->setCustomer($payer->pay_cont_id ?? 'teste');
        $faturaAsas->setDueDate($fatura->data_vencimento);
        $faturaAsas->setExternalReference($fatura->id);
        $texto = '';
        if (isset($fatura->movimento[0]['id'])) {

            foreach ($fatura->movimento as $item) {
                if ($texto == '') {
                    $texto = $item->descricao ?? ' ';
                } else {
                    $texto = $texto . ' + ' . $item->descricao;
                }
                if ($item->valor > 0) {
                    $totalValor = $item->valor + $totalValor;
                }
            }
            $faturaAsas->setDiscountFromMovimentoContasReceber($fatura->movimento);

        } else {

            foreach ($fatura->items as $item) {
                if ($texto == '') {
                    $texto = $item->descricao ?? ' ';
                } else {
                    $texto = $texto . ' + ' . $item->descricao;
                }
                if ($item->valor > 0) {
                    $totalValor = $item->valor + $totalValor;
                }
            }
            $faturaAsas->setDiscountFromMovimentoContasReceber($fatura->items);

        }

        $cartao_credito = (object) $payer->cartao_credito[$payer->cartao_credito->count() - 1];

        if ($cartao_credito->token_cartao == null) {

            $payable = new AsasCliente($payer);
            $payable = $payable->toArray();

            $faturaAsas->setCreditCardHolderInfo(
                [
                    'name' => $payable['name'],
                    'email' => $payable['email'],
                    'cpfCnpj' => $payable['cpfCnpj'],
                    'postalCode' => $payable['postalCode'],
                    'addressNumber' => $payable['addressNumber'],
                    'addressComplement' => empty($payable['complement']) ? 'sem complemento' : $payable['complement'],
                    'phone' => $payable['phone'][0],
                    'mobilePhone' => $payable['mobilePhone'][0],

                ]
            );

            $faturaAsas->setCreditCard(
                [
                    'holderName' => $cartao_credito->dono_cartao,
                    'number' => $cartao_credito->numero,
                    'expiryMonth' => $cartao_credito->mes,
                    'expiryYear' => strval($cartao_credito->ano),
                    'ccv' => $cartao_credito->cvc,

                ]
            );
        } else {
            $faturaAsas->setCreditCardToken($cartao_credito->token_cartao);
        }
        $faturaAsas->setValue($totalValor);
        $faturaAsas->setBillingType('CREDIT_CARD');
        $faturaAsas->setDescription($texto);

        return $faturaAsas;
    }
}
