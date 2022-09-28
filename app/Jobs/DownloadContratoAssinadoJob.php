<?php

namespace App\Jobs;

use App\Models\Contrato;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DownloadContratoAssinadoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Contrato $contrato;

    public function __construct(Contrato $contrato)
    {
        $this->contrato = $contrato;
        $this->delay(now()->addMinute());
    }

    public function handle()
    {
        $clickSignApiService = app('ClicksignApi');
        $document_id = $this->contrato->extra['clicksign']['documentos']['contrato_prestacao_servico'];
        $response = $clickSignApiService->getDocument($document_id);
        $downloadUrl = $response['document']['downloads']['signed_file_url'];

        $fileName = storage_path('app/public/' . $document_id . '.pdf');
        (new Client())->get($downloadUrl, [
            'sink' => $fileName
        ]);
        $storedFile = Storage::disk()->putFile(null, $fileName);
        Storage::disk('public')->delete(basename($fileName));

        $this->contrato->arquivos()->create([
            'nome' => 'contrato_prestacao_servico',
            'nome_original' => $storedFile,
            'caminho' => $storedFile,
            'tags' => [
                'empresa_id' => $this->contrato->empresas_id
            ]
        ]);
    }
}
