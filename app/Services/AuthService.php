<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Usuario;

class AuthService
{
    public function attemptCredentialsCliente(array $data)
    {
        $cliente = Cliente::where('cpf', $data['cpf'])->first();
        abort_if(!$cliente, 404,'Cpf não encontrado.');
        abort_if($cliente->senha != md5($data['senha']), 401,'Senha inválida.');
        return $cliente;
    }

    public function attemptCredentialsUsuario(array $data)
    {
        $usuario = Usuario::where('usuario', $data['usuario'])->first();
        abort_if(!$usuario, 404,'Usuário não encontrado.');
        abort_if($usuario->senha != md5($data['senha']), 401,'Senha inválida.');
        return $usuario;
    }

}
