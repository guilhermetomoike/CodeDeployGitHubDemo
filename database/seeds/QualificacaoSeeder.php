<?php

use Illuminate\Database\Seeder;

class QualificacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Qualificacao::class)->createMany([
            ['nome' => 'Formando',],
            ['nome' => 'Clínico Geral',],
            ['nome' => 'Residente',],
            ['nome' => 'Especialista',],
            ['nome' => 'n/a',],
        ]);
    }
}
