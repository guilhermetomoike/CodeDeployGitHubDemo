<?php

namespace Modules\Invoice\Services\PaymentAdapter;

use App\Exceptions\RegisterInvoiceException;
use App\Services\Recebimento\Gatway\Iugu\Common\IuguFatura;
use Modules\Invoice\Contracts\Invoice\ICreateInvoiceService;


class CreateInvoiceAdapter implements ICreateInvoiceService
{
    private IHttpAdapter $httpAdapter;

    public function __construct(IHttpAdapter $httpAdapter)
    {
        $this->httpAdapter = $httpAdapter;
    }

    public function execute(IuguFatura $fatura): array
    {
        $response = $this->httpAdapter->request('post', 'invoices', $fatura->toArray());
        if (isset($response['errors'])) {
            throw new RegisterInvoiceException(implode(', ', $response['errors']), 400);
        }
        return $response;
    }
}
