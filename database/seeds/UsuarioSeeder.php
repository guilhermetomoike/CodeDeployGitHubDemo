<?php

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Usuario::find(99)) {
            $usuario = factory(\App\Models\Usuario::class)->create([
                'id' => 99,
                'usuario' => 'teste',
                'senha' => 'senha',
            ]);

            $carteira = factory(\App\Models\Carteira::class)->create(['setor' => 'contabilidade']);
            $usuario->carteira()->save($carteira);
        }

        factory(Usuario::class, 5)->create();

    }
}
