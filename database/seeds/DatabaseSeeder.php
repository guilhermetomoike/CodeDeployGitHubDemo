<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\EstadoCivilSeeder::class);
        $this->call(\ProfissaoSeeder::class);
        $this->call(\QualificacaoSeeder::class);
        $this->call(\EspecialidadeSeeder::class);
        $this->call(\IesSeeder::class);
        $this->call(\TabelaIrSeeder::class);
        $this->call(\PlanSeeder::class);
        $this->call(\PlanosSeeder::class);
        $this->call(\JuntaComercialSeeder::class);

        $this->call(\UsuarioSeeder::class);
        $this->call(\RolesAndPermissionsSeeder::class);

        \App\Models\Cliente::withoutEvents(function() {
            $this->call(\ClienteSeeder::class);
        });

        $this->call(CarteiraSeeder::class);
        $this->call(\EmpresaSeeder::class);

        $this->call(\OrdemServico::class);

        $this->call(\ApontamentoSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(CidadeSeeder::class);

        $this->call(CreateRequiredGuidesSeeder::class);
        $this->call(\CoursesSeeder::class);
    }
}
