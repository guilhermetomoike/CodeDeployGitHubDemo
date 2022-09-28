<?php

namespace App\Observers;

use App\Models\Cliente;

class ClienteObserver
{
    public function created(Cliente $cliente)
    {
        if (!$cliente->senha) {
            $cliente->setSenhaDefault();
        }
    }
}
