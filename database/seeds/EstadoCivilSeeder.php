<?php

use App\Models\EstadoCivil;
use Illuminate\Database\Seeder;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EstadoCivil::class)->createMany([
            ['nome' => 'Casado(a)', ],
            ['nome' => 'União Estável', ],
            ['nome' => 'Viuvo(a)', ],
            ['nome' => 'Divorciado(a)', ],
            ['nome' => 'Solteiro', ],
        ]);
    }
}
