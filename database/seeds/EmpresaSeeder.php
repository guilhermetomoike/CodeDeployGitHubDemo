<?php

use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresa = null;
        Empresa::withoutEvents(function () use (&$empresa) {
            if (!Empresa::find(74)) {
                $empresa = factory(Empresa::class,)->create(['id' => 74]);
            }
            factory(Empresa::class, 20)->create();

            $carteira = \App\Models\Carteira::get();

            $clientes = Cliente::all();

            Empresa::all()->each(function (Empresa $empresa) use ($carteira, $clientes) {
                $empresa->carteiras()->sync($carteira);
                $empresa->cartao_credito()->create(factory(\App\Models\CartaoCredito::class)->make()->toArray());
                $empresa->socios()->attach($clientes->random()->id, ['socio_administrador' => true, 'porcentagem_societaria' => 100]);
                $empresa->endereco()->create(factory(\App\Models\Endereco::class)->make()->toArray());
                $empresa->faturamentos()->createMany(factory(\App\Models\Faturamento::class, 10)->make()->toArray());
                $empresa->precadastro()->create(factory(\App\Models\EmpresaPreCadastro::class)->make()->toArray());
                $empresa->contrato()->create();
//                $empresa->acessos_prefeituras()->create();
                $empresa->guia_liberacao()->createMany(factory(\App\Models\GuiaLiberacao::class, 5)->make()->toArray());
                $empresa->guias()->createMany(factory(\App\Models\Guia::class, 10)->make()->toArray());
                $empresa->contatos()->createMany(factory(\App\Models\Contato::class, 5)->make()->toArray());
//                $empresa->crm()->create();
//                $empresa->fatura()->create();
//                $empresa->certificado_digital()->create();
//                $empresa->contas_bancarias()->create();
            });

            if ($empresa = Empresa::find(74)) {
                $empresa->socios()->sync([74 => ['socio_administrador' => true, 'porcentagem_societaria' => 100]]);
            }
        });
    }
}
