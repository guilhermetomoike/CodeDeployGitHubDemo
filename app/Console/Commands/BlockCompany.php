<?php

namespace App\Console\Commands;

use App\Models\Empresa;
use App\Notifications\EncerramentoDeEmpresas\BlockCompanyNotification;
use App\Repositories\EmpresaRepository;
use Illuminate\Console\Command;

class BlockCompany extends Command
{
    protected $signature = 'block:company';
    protected $description = 'Command description';
    private EmpresaRepository $empresaRepository;

    public function __construct(EmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;

        parent::__construct();
    }

    public function handle()
    {
        $empresas = $this->empresaRepository->getEmpresasDesativacaoAgendada();

        foreach ($empresas as $empresa) {
            if($empresa->motivo_desativacao->data_encerramento <= date("Y-m-d")) {
                $empresa->update(['status_id' => array_search( 'Desativada', Empresa::$status)]);

                $empresa->delete();

                $empresa->notify(new BlockCompanyNotification($empresa));
            }
        }
    }
}
