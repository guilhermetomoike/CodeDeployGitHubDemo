<?php

use Illuminate\Database\Seeder;

class CarteiraSeeder extends Seeder
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
                'nome' => 'rh',
                'setor' => 'rh',
                'responsavel_id' => 99
            ],
          [
              'nome' => 'Contábil 1',
              'setor' => 'contabildiade',
              'responsavel_id' => 99
          ],
            [
                'nome' => 'onbording',
                'setor' => 'onboarding',
                'responsavel_id' => 99
            ],
        ];

        foreach ($data as $value) {
            \Illuminate\Support\Facades\DB::table('carteiras')->insert($value);
        }
    }
}
