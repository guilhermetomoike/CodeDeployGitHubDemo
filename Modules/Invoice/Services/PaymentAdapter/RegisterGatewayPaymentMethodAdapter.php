<?php


namespace Modules\Invoice\Services\PaymentAdapter;


use App\Models\Payer\PayerContract;

class RegisterGatewayPaymentMethodAdapter
{
    use CustomerGatewayService;

    private IHttpAdapter $httpAdapter;

    public function __construct(IHttpAdapter $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    public function execute(PayerContract $payer, string $token)
    {
        if (!$payer->iugu_id) {
            $payer = $this->createCustomer($payer);
        }

        $response = $this->httpAdapter
            ->request('post', "customers/{$payer->iugu_id}/payment_methods", [
                'token' => $token,
                'description' => 'Meu cartão de crédito',
                'set_as_default' => true
            ]);

        if (isset($response['errors'])) {
            throw new \Exception(end($response['errors']));
        }
        return $response;
    }
}
