<?php


namespace Modules\Invoice\Services\PaymentAdapter;


use App\Models\Payer\PayerContract;
use App\Services\Recebimento\Gatway\Iugu\Common\IuguCliente;


trait CustomerGatewayService
{
    public function createCustomer(PayerContract $payer)
    {
        $payable = new IuguCliente($payer);
        $response = $this->httpAdapter->request('post', 'customers', $payable->toArray());
        if (isset($response['errors'])) {
            throw new \Exception($response['errors']);
        }
        $payer->iugu_id = $response['id'];
        return $payer;
    }
}
