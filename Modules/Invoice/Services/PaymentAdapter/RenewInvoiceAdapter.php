<?php

namespace Modules\Invoice\Services\PaymentAdapter;

use App\Services\Recebimento\Gatway\Iugu\Common\IuguFatura;
use App\Services\Recebimento\Gatway\Iugu\Common\PaymentSubItem;
use Modules\Invoice\Entities\Fatura;


class RenewInvoiceAdapter
{
    private IHttpAdapter $httpAdapter;

    public function __construct(IHttpAdapter $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    public function execute(Fatura $fatura): Fatura
    {
        $response = $this->httpAdapter->request('post', 'invoices/' . $fatura->gatway_fatura_id . '/duplicate', [
            'due_date' => today()->addDays(1)->toDateString(),
            'current_fines_option' => true
        ]);

        if (isset($response['errors'])) {
            throw new \Exception(implode(', ', $response['errors']), 400);
        }

        $fatura->status = $this->qualifyStatus($fatura);
        $fatura->gatway_fatura_id = $response['id'];
        $fatura->fatura_url = $response['secure_url'];
        $fatura->data_vencimento = $response['due_date'];
        $fatura->pix_qrcode_text = $response['pix']['qrcode_text'] ?? null;
        $fatura->save();

        return $fatura;
    }

    private function qualifyStatus(Fatura $fatura): string
    {
        if (today()->isAfter($fatura->data_vencimento) || in_array($fatura->status, ['atrasado', 'expirado'])) {
            return 'atrasado';
        }
        return 'pendente';
    }
}
