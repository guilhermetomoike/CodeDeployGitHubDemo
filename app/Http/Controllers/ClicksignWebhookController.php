<?php

namespace App\Http\Controllers;

use App\Jobs\DownloadContratoAssinadoJob;
use App\Models\Contrato;
use App\Notifications\AberturaEmpresas\ContratoAssinadoNotification;
use App\Repositories\ContratoRepository;
use App\Services\SlackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClicksignWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        ContratoRepository $contratoRepository
    )
    {
        if ($request->header('Event') != 'auto_close') {
            return response()->noContent();
        }

        $generatedHash = hash_hmac('sha256', $request->getContent(), config('services.clicksign.webhook_secret'));
        $receivedHash = $request->header('Content-Hmac');

        if ($receivedHash != "sha256={$generatedHash}") {
            return abort(403);
        }

        $documentKey = $request->document['key'];
        $contrato = $contratoRepository->findByDocumentKey($documentKey);
        $empresa = $contrato->empresa;

        if ($empresa->status_id == 2) {
            $empresa->status_id = 3;
            $empresa->save();
        }

        $contrato->signed_at = now();
        $contrato->save();

        $this->dispatch(new DownloadContratoAssinadoJob($contrato));

        $empresa->notify(new ContratoAssinadoNotification());

        return response()->noContent();
    }
}
