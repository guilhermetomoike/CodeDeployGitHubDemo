<?php


namespace Modules\Irpf\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Irpf\Services\SendEmailDeclaracaoService;
use Modules\Irpf\Services\UpdateFaturaStatusService;

class WebhookChargeController
{
    public function __invoke(Request $request, UpdateFaturaStatusService $updateFaturaStatus)
    {
        Log::channel('stack')->info(json_encode($request->all()));

        if ($updateFaturaStatus->isInvalidChange($request)) {
            return response()->noContent();
        }

        $fatura = $updateFaturaStatus->execute($request->data['id'], $request->data['payment_method']);
        $payer = $fatura->payer;

        $emailSender = new SendEmailDeclaracaoService($payer->irpf);
        call_user_func($emailSender);

        return response()->noContent();
    }
}
