<?php


namespace Modules\Invoice\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Modules\Invoice\Http\Requests\PayInvoicesRequest;
use Modules\Invoice\Services\ChargeInvoiceService;

class PayInvoiceController
{
    public function __invoke(PayInvoicesRequest $request, ChargeInvoiceService $service, $payer_type, $payer_id): JsonResponse
    {
        $data = $request->validated();
        $paid = $service->fromFromRequest($data);
        if ($paid) {
            return new JsonResponse([
                'message' => 'Operação realizada com sucesso.'
            ]);
        }
        return new JsonResponse([
            'message' => 'Falha ao processar o pagamento.'
        ], 400);
    }
}
