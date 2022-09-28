<?php


namespace Modules\Invoice\Http\Controllers;


use Illuminate\Http\Response;
use Modules\Invoice\Http\Requests\SendInvoicesRequest;
use Modules\Invoice\Services\SendInvoice\ISendPendingInvoices;

class SendInvoiceController
{
    private ISendPendingInvoices $sendPendingInvoices;

    public function __construct(ISendPendingInvoices $sendPendingInvoices)
    {
        $this->sendPendingInvoices = $sendPendingInvoices;
    }

    public function __invoke(SendInvoicesRequest $request)
    {
        $data = $request->validated();
        try {
            $this->sendPendingInvoices->execute($data);
        } catch (\Exception $e) {
            return response()->json(
                ['message' => 'Não foi possível realizar a operação. | ' . $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
        return response()->json(['message' => 'Operação realizada com sucesso.']);
    }
}
