<?php

namespace App\Jobs;

use App\Mail\EmpresaCadastradaMail;
use App\Models\Empresa;
use App\Services\ContratoService;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class MakeContratoEmpresaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Empresa $empresa;
    private bool $sendEmail;

    public function __construct(Empresa $empresa, bool $sendEmail = true)
    {
        $this->empresa = $empresa;
        $this->sendEmail = $sendEmail;
    }

    public function tags()
    {
        return ['empresa:' . $this->empresa->id];
    }

    public function handle()
    {
        $contratoService = new ContratoService($this->empresa);
        $documents = $this->validateDocument($contratoService);
        $this->empresa->contrato()->updateOrCreate([], [
            'extra' => ['clicksign' => $documents],
        ]);
        if ($this->empresa->status_id < 2) {
            $this->empresa->status_id = 2;
        }
        $this->empresa->save();
        if ($this->sendEmail) {
            Mail::send(new EmpresaCadastradaMail($this->empresa));
        }
    }

    public function validateDocument($contratoService)
    {
        if ($this->empresa->type == 'atletica') {
            return $this->validateTypeAtletica($contratoService);
        }

        return $contratoService->createDocuments(['contrato_prestacao_servico']);
    }

    public function validateTypeAtletica($contratoService)
    {
        if($this->empresa->plans()->first()->slug == 'ecommerce') {
            return $contratoService->createDocuments(['contrato_atletica_ecommerce']);
        }

        if($this->empresa->plans()->first()->slug == 'accounting-ecommerce') {
            return $contratoService->createDocuments(['contrato_atletica_contabilidade_ecommerce']);
        }

        return $contratoService->createDocuments(['contrato_atletica_contabilidade']);
    }
}
