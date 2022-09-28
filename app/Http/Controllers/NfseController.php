<?php

namespace App\Http\Controllers;

use App\Http\Resources\NfseResource;
use App\Models\Nfse\Nfse;
use App\Repositories\NfseRepository;
use App\Services\Nfse\NfseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NfseController extends Controller
{
    private NfseService $nfseService;
    private NfseRepository $nfseRepository;

    public function __construct(NfseService $nfseService, NfseRepository $nfseRepository)
    {
        $this->nfseService = $nfseService;
        $this->nfseRepository = $nfseRepository;
    }

    public function index(Request $request)
    {
        $params['date'] = $request->get('date');
        $data = $this->nfseRepository->getNfses($params);
        return NfseResource::collection($data);
    }

    public function destroy(int $id)
    {
        $cancelResponse = $this->nfseService->cancelar($id);
        return response(['message' => $cancelResponse->message]);
    }

    public function webhook(Request $request)
    {
        $data = $request->json()->all();
        Log::channel('stack')->info(json_encode($data));
        $this->nfseService->receiveWebhook($data);
        return response('recebido');
    }

    public function emitByInvoiceId(Request $request)
    {
        $this->validate($request, [
            'fatura_id' => 'exists:fatura,id'
        ]);
        $this->nfseService->dispatchByInvoiceId($request->fatura_id);
        return response(['message' => 'solicitado com sucesso']);
    }

    public function refreshStatus(string $idIntegracao)
    {
        $this->nfseService->refreshStatus($idIntegracao);
        return response(['message' => 'solicitado com sucesso']);
    }
    public function imitirRejeitadas()
    {
        $faturas = Nfse::whereDate('created_at', '>', "2022-04-03")
            ->whereDate('created_at', '<', "2022-05-01")->get();
       
        foreach ($faturas as $fatura) {
            $this->nfseService->dispatchByInvoiceId($fatura->fatura_id);
        }
    }
}
