<?php

use App\Models\Servico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicosSeeder extends Seeder
{
    public function run()
    {
        // Cria os servicos
        $this->createServicos();
    }

    private function createServicos()
    {
        $servicos = $this->getServicos();

        foreach ($servicos as $servico) {
            $this->createServico($servico);
        }
    }

    private function getServicos()
    {
        return [
            ['descricao' => 'Clínico Geral'],
            ['descricao' => 'Atendimento'],
            ['descricao' => 'Plantão']
        ];
    }

    private function createServico($servico)
    {
        return Servico::create([
            'descricao' => $servico['descricao'],
        ]);
    }
}
