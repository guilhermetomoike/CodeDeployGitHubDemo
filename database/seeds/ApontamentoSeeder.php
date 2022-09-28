<?php

use Illuminate\Database\Seeder;
use Modules\Apontamentos\Entities\Apontamento;

class ApontamentoSeeder extends Seeder
{
    public function run()
    {
        factory(Apontamento::class, 50)->create();
    }
}
