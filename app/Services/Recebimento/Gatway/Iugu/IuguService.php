<?php

namespace App\Services\Recebimento\Gatway\Iugu;

use App\Jobs\CreateIuguPaymentMethodJob;
use App\Models\Payer\PayerContract;
use App\Models\Contrato;
use App\Models\Empresa;
use Modules\Invoice\Entities\Fatura;
use App\Repositories\CartaoCreditoRepository;
use App\Services\Recebimento\Contracts\Recebimento;
use App\Services\Recebimento\Gatway\Iugu\Common\IuguFatura;
use App\Services\Recebimento\Gatway\Iugu\Common\IuguSubscription;
use App\Services\Recebimento\Gatway\Iugu\Common\PaymentSubItem;
use Illuminate\Support\Collection;

class IuguService implements Recebimento
{
    private $Api;
    private $CartaoCreditoRepository;

    public function __construct()
    {
        $this->Api = new Api();
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
        $iugu_cliente = $this->Api->cadastrarCliente($payer);
        $payer->update(['iugu_id' => $iugu_cliente->id]);
        return $payer;
    }

    public function criarCobrancaDireta(array $request)
    {
        $empresa = Empresa::find($request['empresa_id']);
        if (!$empresa->iugu_id) {
            $empresa = $this->criarCliente($empresa);
        }
        $response = $this->Api->receber($empresa, $request['token_cartao'], $request['valor'], $request['descricao'] ?? null);
        if ($response->success) {
            $empresa->transacao_recebimento()->create([
                'valor' => $request['valor'],
                'status' => 'autorizada',
                'descricao' => $request['descricao'] ?? 'cobranca direta',
                'response' => $response
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
        if (!$payer->iugu_id) {
            $payer = $this->criarCliente($payer);
        }

        $cartao_credito = $payer->cartao_credito;
        if (!$cartao_credito || ($cartao_credito && !$cartao_credito->token_cartao)) {
            return false;
        }
        try {
            $response = $this->Api->criarFormaPagamento($payer->iugu_id, $cartao_credito->token_cartao);
        } catch (\Exception $e) {
            $erro = json_decode($e->getMessage());
            if ($erro->errors && $erro->errors->token && $erro->errors->token[0] == 'Esse token já foi usado.') {
                $cartao_credito->delete();
            }
            abort(400, json_encode($erro));
        }

        $cartao_credito->used = true;
        $cartao_credito->save();

        return $payer->contrato()->updateOrCreate([
            'empresas_id' => $payer->id
        ], [
            'forma_pagamento_gatway_id' => $response->id,
            'forma_pagamento_gatway_data' => $response->data
        ]);
    }

    public function criarAssinatura(PayerContract $payer)
    {
        if (!$payer->iugu_id) {
            $payer = $this->criarCliente($payer);
        }

        if (!$payer->contrato->forma_pagamento_gatway_id) {
            $forma_pagamento_padrao = $this->criarFormaPagamento($payer);
            abort_if(!$forma_pagamento_padrao, 400, 'Não foi possível criar forma de pagamento');
        }

        // busca servicos inscritos para o pagador e qualifica para api iugu
        $items = $this->qualifyChargeablePlans(null, $payer->contrato);

        // constroi objeto de subscricao
        $subscription = IuguSubscription::build()
            ->setCustomerId($payer->iugu_id)
            ->resolveExpiresAt()
            ->setPlanIdentifier('mensal')
            ->setSubitems($items)
            ->setExpiresAt(date('d-m-Y'));

        $this->Api->criarAssinatura($subscription);

        $payer->contrato->update(['forma_pagamento_id' => 2]);

    }

    public function criarFatura(IuguFatura $faturaObject)
    {
        return $this->Api->criarFatura($faturaObject);
    }

    public function criarFaturaWithItems(Fatura $fatura): Fatura
    {
        $payer = $fatura->payer;
        if (!$payer->iugu_id) {
            $payer = $this->criarCliente($payer);
        }

        $faturaIugu = new IuguFatura;
        $faturaIugu->setCustomerId($payer->iugu_id);
        $faturaIugu->setDueDate($fatura->data_vencimento);
        $faturaIugu->setEmail($payer->contatos()->email());
        $faturaIugu->setItemsFromFatura($fatura->items);

        $response = $this->criarFatura($faturaIugu);

        $fatura->gatway_fatura_id = $response->id;
        $fatura->fatura_url = $response->secure_url;
        $fatura->pix_qrcode_text = $response->pix->qrcode_text ?? null;
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
                $fatura->payer_type => $fatura->payer_id
            ]
        ]);
    }
}
