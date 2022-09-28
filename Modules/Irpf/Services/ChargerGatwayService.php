<?php


namespace Modules\Irpf\Services;


use App\Models\Payer\PayerContract;
use App\Services\Recebimento\Contracts\Recebimento;
use App\Services\Recebimento\Gatway\Iugu\Common\IuguFatura;
use App\Services\Recebimento\Gatway\Iugu\IuguService;
use Modules\Invoice\Entities\Fatura;

class ChargerGatwayService extends IuguService implements Recebimento
{
    public function criarFaturaWithItems(Fatura $fatura): Fatura
    {
        $payer = $fatura->payer;
        if (!$payer->iugu_id) {
            $payer = $this->criarCliente($payer);
        }
        $faturaObject = $this->createFaturaObject($fatura, $payer);
        return $this->createFaturaApi($faturaObject, $fatura);
    }

    private function createFaturaObject(Fatura $fatura, PayerContract $payer)
    {
        $faturaIugu = new IuguFatura;
        $faturaIugu->setCustomerId($payer->iugu_id);
        $faturaIugu->setDueDate($fatura->data_vencimento);
        $faturaIugu->setEmail($payer->contatos()->email());
        $faturaIugu->setItemsFromFatura($fatura->items);
        $faturaIugu->setNotificationUrl(config('irpf.webhook_charge_url'));
        return $faturaIugu;
    }

    private function createFaturaApi(IuguFatura $faturaObject, Fatura $fatura)
    {
        $response = $this->criarFatura($faturaObject);

        $fatura->gatway_fatura_id = $response->id;
        $fatura->fatura_url = $response->secure_url;
        $fatura->save();
        return $fatura;
    }
}
