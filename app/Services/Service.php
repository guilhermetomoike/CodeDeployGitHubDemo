<?php

namespace App\Services;

class Service
{
    public function getCurrentUser()
    {
        $login = auth('api_usuarios')->user();

        if (!$login) {
            $login = auth('api_clientes')->user();
        }

        return $login;
    }

    public function getTypeCurrentUser()
    {
        if (get_class($this->getCurrentUser()) === 'App\Models\Usuario') {
            return 'usuario';
        }

        if (get_class($this->getCurrentUser()) === 'App\Models\Cliente') {
            return 'cliente';
        }

        return null;
    }
}
