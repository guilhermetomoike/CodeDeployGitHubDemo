<?php

namespace App\Console\Commands;

use App\Jobs\MakeContratoEmpresaJob;
use App\Models\Empresa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class MakeContratoEmpresaCommand extends Command
{
    protected $signature = 'gerar:contrato {empresa}';

    protected $description = 'Dispara o job MakeContratoEmpresaJob e retorna o link para assinatura';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $empresa = Empresa::findOrFail($this->argument('empresa'));
        $token = Auth::guard('api_clientes')->login($empresa->socioAdministrador[0]);

        MakeContratoEmpresaJob::dispatchNow($empresa);

        $this->line("https://cliente.medb.com.br/assinar-contrato?token={$token}&empresaId={$empresa->id}");
    }
}
