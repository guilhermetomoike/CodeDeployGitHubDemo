<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CidadeSeeder extends Seeder
{
    public function run()
    {
        DB::table('cidades')->insert(include 'cidades.php');
    }
}
