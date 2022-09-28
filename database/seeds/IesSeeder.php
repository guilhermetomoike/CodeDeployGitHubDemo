<?php

use App\Models\Ies;
use Illuminate\Database\Seeder;

class IesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Ies::class)->createMany([
            ['nome' => 'USP', 'estado' => 'SP', 'faculdade' => 'Universidade de São Paulo', ],
            ['nome' => 'UNICAMP', 'estado' => 'SP', 'faculdade' => 'Universidade Estadual de Campinas', ],
            ['nome' => 'UFRJ', 'estado' => 'RJ', 'faculdade' => 'Universidade Federal do Rio de Janeiro', ],
            ['nome' => 'UFMG', 'estado' => 'MG', 'faculdade' => 'Universidade Federal de Minas Gerais', ],
            ['nome' => 'UFRGS', 'estado' => 'RS', 'faculdade' => 'Universidade Federal do Rio Grande do Sul', ],
            ['nome' => 'UNESP', 'estado' => 'SP', 'faculdade' => 'Universidade Estadual Paulista Júlio de Mesquita Filho', ],
            ['nome' => 'UFSC', 'estado' => 'SC', 'faculdade' => 'Universidade Federal de Santa Catarina', ],
            ['nome' => 'UFPR', 'estado' => 'PR', 'faculdade' => 'Universidade Federal do Paraná', ],
            ['nome' => 'UNB', 'estado' => 'DF', 'faculdade' => 'Universidade de Brasília', ],
            ['nome' => 'UFPE', 'estado' => 'PE', 'faculdade' => 'Universidade Federal de Pernambuco', ],
            ['nome' => 'UFC', 'estado' => 'CE', 'faculdade' => 'Universidade Federal do Ceará', ],
            ['nome' => 'UFSCAR', 'estado' => 'SP', 'faculdade' => 'Universidade Federal de São Carlos', ],
            ['nome' => 'UERJ', 'estado' => 'RJ', 'faculdade' => 'Universidade do Estado do Rio de Janeiro', ],
            ['nome' => 'UFBA', 'estado' => 'BA', 'faculdade' => 'Universidade Federal da Bahia', ],
            ['nome' => 'UFV', 'estado' => 'MG', 'faculdade' => 'Universidade Federal de Viçosa', ],
            ['nome' => 'UNIFESP', 'estado' => 'SP', 'faculdade' => 'Universidade Federal de São Paulo', ],
            ['nome' => 'UFF', 'estado' => 'RJ', 'faculdade' => 'Universidade Federal Fluminense', ],
            ['nome' => 'PUCRS', 'estado' => 'RS', 'faculdade' => 'Pontifícia Universidade Católica do Rio Grande do Sul', ],
            ['nome' => 'PUC Rio', 'estado' => 'RJ', 'faculdade' => 'Pontifícia Universidade Católica do Rio de Janeiro', ],
            ['nome' => 'UFG', 'estado' => 'GO', 'faculdade' => 'Universidade Federal de Goiás', ],
            ['nome' => 'UFSM', 'estado' => 'RS', 'faculdade' => 'Universidade Federal de Santa Maria', ],
            ['nome' => 'UFRN', 'estado' => 'RN', 'faculdade' => 'Universidade Federal do Rio Grande do Norte', ],
            ['nome' => 'UEL', 'estado' => 'PR', 'faculdade' => 'Universidade Estadual de Londrina', ],
            ['nome' => 'UEM', 'estado' => 'PR', 'faculdade' => 'Universidade Estadual de Maringá', ],
            ['nome' => 'UFU', 'estado' => 'MG', 'faculdade' => 'Universidade Federal de Uberlândia', ],
        ]);
    }
}
