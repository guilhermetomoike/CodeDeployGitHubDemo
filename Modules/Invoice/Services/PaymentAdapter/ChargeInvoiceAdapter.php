<?php


namespace Modules\Invoice\Services\PaymentAdapter;


use App\Models\CartaoCredito;
use Modules\Invoice\Entities\Fatura;

class ChargeInvoiceAdapter
{
    private IHttpAdapter $httpAdapter;

    public function __construct(IHttpAdapter $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    public function execute(Fatura $fatura, ?CartaoCredito $payment_method_id = null)
    {
        $payment_method_id ??= $fatura->payer->cartao_credito->first();

        $response = $this->httpAdapter->request('post', 'charge', [
            'customer_payment_method_id' => $payment_method_id->forma_pagamento_gatway_id,
            'customer_id' => $fatura->payer->iugu_id,
            'invoice_id' => $fatura->gatway_fatura_id,
        ]);

        if (isset($response['message']) && $response['message'] === 'Autorizado') {
            $fatura->status = 'pago';
            $fatura->data_recebimento = today();
            $fatura->forma_pagamento_id = 2;
        }

        return $fatura;
    }
}
