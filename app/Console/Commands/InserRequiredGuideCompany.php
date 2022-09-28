<?php

namespace App\Console\Commands;

use App\Models\Empresa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InserRequiredGuideCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:required-guide';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $empresas = Empresa::all();

        foreach ($empresas as $empresa) {
            if ($empresa->regime_tributario == 'SN') {
                $this->attachSN($empresa);
            }
            if ($empresa->regime_tributario == 'Presumido') {
                $this->attachPresumido($empresa);
            }
        }
    }

    public function attachSN(Empresa $empresa)
    {
        $data = Empresa\RequiredGuide::query()
            ->whereIn('name',
                ['DAS', 'IRRF', 'INSS', 'HONORARIOS'])
            ->pluck('id')
            ->toArray();

        $this->attach($empresa, $data);
    }

    public function attachPresumido(Empresa $empresa)
    {
        $data = Empresa\RequiredGuide::query()
            ->whereIn('name',
                ['ISS', 'HONORARIOS', 'IRRF', 'INSS', 'PIS/COFINS', 'IRPJ/CSLL'])
            ->pluck('id')
            ->toArray();

        $this->setTrimestral($empresa);

        $this->attach($empresa, $data);
    }

    public function attach($empresa, $data)
    {
        return DB::transaction(function () use ($empresa, $data) {
            $empresa->required_guide()->detach();

            foreach ($data as $guide) {
                $empresa->required_guide()->attach($guide);
            }

            return $empresa;
        });
    }

    public function setTrimestral(Empresa $empresa)
    {
        $empresa->update(['trimestral' => true]);
    }
}
