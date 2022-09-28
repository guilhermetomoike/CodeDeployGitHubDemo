<?php

use Illuminate\Database\Seeder;

class TabelaIrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabelaIr = [
            [
                'base_calculo_from' => 0,
                'base_calculo_to' => 1903.98,
                'aliquota' => 0,
                'deducao' => 0
            ],
            [
                'base_calculo_from' => 1903.99,
                'base_calculo_to' => 2826.65,
                'aliquota' => 7.5,
                'deducao' => 142.80
            ],
            [
                'base_calculo_from' => 2826.66,
                'base_calculo_to' => 3751.05,
                'aliquota' => 15,
                'deducao' => 354.80,
            ],
            [
                'base_calculo_from' => 3751.06,
                'base_calculo_to' => 4664.68,
                'aliquota' => 22.5,
                'deducao' => 636.13
            ],
            [
                'base_calculo_from' => 4664.68,
                'aliquota' => 27.5,
                'deducao' => 869.36
            ]
        ];

        foreach ($tabelaIr as $faixa){
            \App\Models\TabelaIr::create($faixa);
        }
    }
}
