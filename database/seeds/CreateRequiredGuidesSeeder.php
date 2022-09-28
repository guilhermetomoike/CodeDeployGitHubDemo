<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateRequiredGuidesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'INSS',
                'type' => 'rh',
                'active' => 1,
            ],
            [
                'name' => 'HOLERITE',
                'type' => 'rh',
                'active' => 1,
            ],
            [
                'name' => 'IRRF',
                'type' => 'rh',
                'active' => 1,
            ],
            [
                'name' => 'ISS',
                'type' => 'contabilidade',
                'active' => 1,
            ],
            [
                'name' => 'DAS',
                'type' => 'contabilidade',
                'active' => 1,
            ],
            [
                'name' => 'FGTS',
                'type' => 'rh',
                'active' => 1,
            ],
            [
                'name' => 'PIS/COFINS',
                'type' => 'contabilidade',
                'active' => 1,
            ],
            [
                'name' => 'IRPJ/CSLL',
                'type' => 'contabilidade',
                'active' => 1,
            ],

        ];

        DB::table('required_guides')->insert($data);
    }
}
