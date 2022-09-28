<?php


namespace Modules\Invoice\Services;


use App\Models\CartaoCredito;
use Modules\Invoice\Entities\Fatura;
use Modules\Invoice\Services\PaymentAdapter\ChargeInvoiceAdapter;

class ChargeInvoiceService
{
    private ChargeInvoiceAdapter $adapter;

    public function __construct(ChargeInvoiceAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function fromFromRequest(array $data)
    {
        $paymentMethod = CartaoCredito::find($data['credit_card_id']);
        $faturas = Fatura::query()
            ->whereIn('id', $data['invoices'])
            ->get();

        $paid = 0;
        $faturas->each(function (Fatura $fatura) use ($paymentMethod, &$paid) {
            $changedInvoice = $this->adapter->execute($fatura, $paymentMethod);
            if ($changedInvoice->status === 'pago') {
                $paid++;
            }
        });

        return $paid === $faturas->count();
    }
}
