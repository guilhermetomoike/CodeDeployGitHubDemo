<?php

namespace Modules\Invoice\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\Services\DataTransfer\ChangeInvoiceWebhook\StatusChangeDataTransfer;
use Modules\Invoice\Services\Webhook\IChangeInvoiceStatus;

class WebhookInvoiceStatusChangeController
{

    public function __invoke(Request $request, IChangeInvoiceStatus $changeInvoiceStatus)
    {
        Log::channel('stack')->info(json_encode($request->all()));
        $data = StatusChangeDataTransfer::FromArray($request->all());
        $changed = $changeInvoiceStatus->execute($data);
        if (!$changed) {
            Log::channel('stack')->info('status not changed.');
            return response()->json(['message' => 'status not changed.'], 400);
        }
        return response()->json(['message' => 'status changed.']);
    }
}
