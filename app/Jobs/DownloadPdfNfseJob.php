<?php

namespace App\Jobs;

use App\Models\Nfse\Nfse;
use App\Services\Nfse\NfseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadPdfNfseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Nfse $nfse;

    public function __construct(Nfse $nfse)
    {
        $this->nfse = $nfse;
    }

    public function tags()
    {
        return ['nfse', 'download_pdf', 'empresa_id:' . $this->nfse->empresas_id];
    }

    public function handle(NfseService $nfseService)
    {
        if ($this->attempts() > 1) {
            $this->release(1200);
        }
        if ($this->attempts() > 2) {
            $this->release(9000);
        }

        $downloaded_file = $nfseService->getGatewayInstance()->downloadPdf($this->nfse);
        $this->nfse->arquivo()->create([
            'nome_original' => $downloaded_file,
            'caminho' => $downloaded_file
        ]);
    }
}
