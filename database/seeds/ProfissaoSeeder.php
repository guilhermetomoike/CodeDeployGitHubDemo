<?php

use Illuminate\Database\Seeder;

class ProfissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Profissao::class, 20)->create();
    }
}
