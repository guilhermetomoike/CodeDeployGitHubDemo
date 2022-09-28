<?php


namespace Modules\Invoice\Services\PaymentAdapter;


use App\Models\Payer\PayerContract;


class RemoveGatewayPaymentMethodAdapter
{
    private IHttpAdapter $httpAdapter;

    public function __construct(IHttpAdapter $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    public function execute(string $customer_id, string $payment_method_id): bool
    {
        $response = $this->httpAdapter
            ->request('delete', "customers/{$customer_id}/payment_methods/$payment_method_id");

        return isset($response['id']);
    }
}
