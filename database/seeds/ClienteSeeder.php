<?php

use App\Models\CartaoCredito;
use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Endereco;
use App\Models\IrpfAssets;
use Illuminate\Database\Seeder;
use Modules\Irpf\Entities\DeclaracaoIrpf;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        if (!Cliente::find(74)) {
            $tiago = factory(Cliente::class)->create([
                'id' => 74,
                'cpf' => '06013595933',
                'senha' => '06013595933',
                'nome_completo' => 'Tiago Aquino Martines'
            ]);
        }

        factory(Cliente::class, 20)->create();

        Cliente::all()->each(function ($cliente) {
            $cliente->endereco()->create(factory(Endereco::class)->make()->toArray());
            $cliente->cartao_credito()->create(factory(CartaoCredito::class)->make()->toArray());
            $cliente->contatos()->createMany(factory(Contato::class, 5)->make()->toArray());
            $irpf = $cliente->irpf()->create(factory(DeclaracaoIrpf::class)->make([
                'ano' => today()->year,
                'qtd_lancamento' => 2
            ])->toArray());
            $irpf->assets()->createMany(factory(IrpfAssets::class, 4)->make()->toArray());
        });
    }
}
