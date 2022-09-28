<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as DBAlias;

class MotivoDesativarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DBAlias::table('motivo_desativar')->insert(['motivo' => 'Troca de Contador']);
    }
}
