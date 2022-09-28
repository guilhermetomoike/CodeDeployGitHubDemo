<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('planos')->insert([
            ['nome' => 'Congelado Anual', 'valor' => 356.00, 'tipo' => 'pj', 'quantitativo' => 1],
            ['nome' => 'Gestão Carreira Residente', 'valor' => 280.00, 'tipo' => 'pj', 'quantitativo' => null],
            ['nome' => 'Sem Cobrança', 'valor' => 0.00, 'tipo' => 'pj', 'quantitativo' => null],
            ['nome' => 'Congelado - Semestral', 'valor' => 178.00, 'tipo' => 'pj', 'quantitativo' => null],
            ['nome' => 'Contabilidade', 'valor' => 178.00, 'tipo' => 'pj', 'quantitativo' => 1],
            ['nome' => 'Gestão Carreira Geral - 2020', 'valor' => 356.00, 'tipo' => 'pj', 'quantitativo' => 1],
            ['nome' => 'Contabilidade Funcionário', 'valor' => 40.00, 'tipo' => 'pj', 'quantitativo' => 1],
            ['nome' => 'Contabilidade Sócio Adicional', 'valor' => 40.00, 'tipo' => 'pj', 'quantitativo' => 1],
            ['nome' => 'Contabilidade - Doméstica', 'valor' => 70.00, 'tipo' => 'pj', 'quantitativo' => 1],
            ['nome' => 'Gestão Carreira - Geral', 'valor' => 350.00, 'tipo' => 'pj', 'quantitativo' => 1],
        ]);
    }
}
