<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JuntaComercialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('junta_comercials')->insert([
            ['estado_id' => 11, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 12, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 13, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 14, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 15, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 16, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 17, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 21, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 22, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 23, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 24, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 25, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 26, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 27, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 28, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 29, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 31, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 32, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 33, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 35, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 41, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 42, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 43, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 50, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 51, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 52, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
            ['estado_id' => 53, 'taxa_alteracao' => 123.45, 'taxa_alteracao_extra' => 0],
        ]);
    }
}
