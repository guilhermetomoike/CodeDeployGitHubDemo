<?php

use App\Models\PlanoSaude;
use Illuminate\Database\Seeder;

class PlanoSaudeSeeder extends Seeder
{
    public function run()
    {
        $this->createPlanos();
    }

    private function createPlanos()
    {
        $planos = $this->getPlanos();

        foreach ($planos as $plano) {
            $this->createPlano($plano);
        }
    }

    private function getPlanos()
    {
        return [
            ['nome' => 'Unimed'],
            ['nome' => 'Pam']
        ];
    }

    private function createPlano($plano)
    {
        return PlanoSaude::create([
            'nome' => $plano['nome'],
        ]);
    }
}
