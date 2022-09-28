<?php

namespace Modules\Invoice\Http\Controllers;

use App\Services\Recebimento\Gatway\Asas\AsasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Irpf\Services\UpdateFaturaStatusService;

class WebhookInvoiceStatusChangeAsaasController
{

    public $status = [
        'RECEIVED' => 'pago',
        'RECEIVED_IN_CASH' => 'pago',
        'PENDING' => 'pendente',
        'CONFIRMED' => 'processando',
        'OVERDUE' => 'atrasado',
        'REFUNDED' => 'estornado',

    ];

    public function index(Request $request, UpdateFaturaStatusService $updateFaturaStatus, AsasService $asasService)
    {

        Log::channel('stack')->info(json_encode($request->all()));

        $fatura = null;

        if ($request->payment['externalReference'] == null) {
            return response()->json(['message' => 'nao e do sistema.']);
        }

        $status = $this->status[$request->payment['status']];
        $id = $request->payment['id'];
        if ($request->payment['billingType'] == 'BOLETO') {
            $payment_method = 1;
        }
        if ($request->payment['billingType'] == 'UNDEFINED') {
            $payment_method = 1;
        }
        if ($request->payment['billingType'] == 'PIX') {
            $payment_method = 3;
        }
        if ($request->payment['billingType'] == 'CREDIT_CARD') {
            $payment_method = 2;
        }
        if ($request->payment['billingType'] == 'TRANSFER') {
            $payment_method = 4;
        }

        // if ($request->event == 'PAYMENT_CREATED') {
        //     $fatura = $updateFaturaStatus->updateStatus($id, $status, $payment_ method);
        // }

        // if ($request->event == 'PAYMENT_OVERDUE') {
        //     $fatura = $updateFaturaStatus->updateStatus($id, $status, $payment_method);
        // }

        // if ($request->event == 'PAYMENT_UPDATED') {
        //     $fatura = $updateFaturaStatus->updateStatus($id, $status, $payment_method);
        // }
        // if ($request->event == 'PAYMENT_RECEIVED') {
        //     $fatura = $updateFaturaStatus->updatePago($id, $status, $payment_method, $request->payment['dueDate'], $request->payment['value']);
        // }
        // if ($request->event == 'PAYMENT_CONFIRMED') {
        //     $fatura = $updateFaturaStatus->updateStatus($id, $status, $payment_method);
        // }
        // if ($request->event == 'PAYMENT_DELETED') {
        //     return response()->json(['message' => 'status changed.']);
        // }

        switch ($request->event) {
            case 'PAYMENT_DELETED':
                return response()->json(['message' => 'boleto deletado.']);
                break;
            case 'PAYMENT_RECEIVED':
                $fatura = $updateFaturaStatus->updatePago($id, $status, $payment_method, $request->payment['dueDate'], $request->payment['value']);
                break;
            case 'PAYMENT_CONFIRMED':
                $fatura = $updateFaturaStatus->updatePago($id, $status, $payment_method, $request->payment['dueDate'], $request->payment['value']);
                break;

            case 'PAYMENT_OVERDUE':
                if (!isset($request->payment['confirmedDate'])) {
                    $fatura = $updateFaturaStatus->updateJuros($request->payment, $asasService);
                    //   if (!$fatura) {
                    //     return response()->json(['message' => $fatura]);
                    //   }
                    // $updateFaturaStatus->updateStatus($id);
                    return response()->json(['message' => 'juros atualizado']);


                } else {
                    return response()->json(['message' => 'not juros']);
                }
                break;

            default:
                // $fatura = $updateFaturaStatus->updateStatus($id);
                return response()->json(['message' => 'status changed updated.']);
                break;
        }

        if (!$fatura) {
            Log::channel('stack')->info('status not changed.');
            return response()->json(['message' => 'status not changed.'], 200);
        }
        return response()->json(['message' => 'status changed.']);
    }
}
