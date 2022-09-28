<?php

namespace App\Console\Commands;

use App\Models\Empresa;
use App\Notifications\CongelamentoDeEmpresas\FreezeCompanyNotification;
use App\Notifications\EncerramentoDeEmpresas\BlockCompanyNotification;
use App\Repositories\EmpresaRepository;
use Illuminate\Console\Command;

class FreezeCompany extends Command
{
    protected $signature = 'freeze:company';

    protected $description = 'Freeze company';

    private EmpresaRepository $empresaRepository;

    public function __construct(EmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;

        parent::__construct();
    }

    public function handle()
    {
        $empresas = $this->empresaRepository->getEmpresasCongelamentoAgendado();

        foreach ($empresas as $empresa) {
            if ($empresa->motivoCongelamento()->latest()->first()->freeze_date <= date("Y-m-d")) {
                $empresa->congelada = true;
                $empresa->status_id = array_search('Congelada', Empresa::$status);
                $empresa->save();

                $empresa->notify(new FreezeCompanyNotification);
            }
        }
    }
}
