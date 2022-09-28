<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function created($data = [])
    {
        return response()->json($data, Response::HTTP_CREATED);
    }

    public function ok($data = [])
    {
        return response()->json($data, Response::HTTP_OK);
    }

    public function badRequest($data)
    {
        return response()->json($data, Response::HTTP_BAD_REQUEST);
    }

    public function badDependencyRequest($data)
    {
        return response()->json($data, Response::HTTP_FAILED_DEPENDENCY);
    }

    public function noContent()
    {
        return response()->json('', Response::HTTP_NO_CONTENT);
    }

    public function getCurrentUser()
    {
        $login = auth('api_usuarios')->user();

        if (!$login) {
            $login = auth('api_clientes')->user();
        }

        return $login;
    }

    public function badAuthenticate($data = [])
    {
        return response()->json($data, Response::HTTP_FORBIDDEN);
    }

    public function getEmpresasIds()
    {
        return $this->getCurrentUser()->empresa->pluck('id')->unique();
    }

    public function ClienteSemAcesso()
    {
        return response()->json([
            'message' => 'Você não tem permissão para acessar este local.'
        ], Response::HTTP_FORBIDDEN);
    }

    public function onlyCliente()
    {
        if (is_a($this->getCurrentUser(), Cliente::class)) {
            $this->ClienteSemAcesso();
        }

        return $this->getCurrentUser();
    }

    public function isCliente()
    {
        if (is_a($this->getCurrentUser(), Cliente::class)) {
            return true;
        }

        return false;
    }

    public function successResponse($data = null, $message = null, int $code = Response::HTTP_OK)
    {
        return response()->json([
            'message' => $message ?? 'Operação realizada com sucesso.',
            'data' => $data
        ], $code);
    }

    public function errorResponse($message = null, $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'message' => $message ?? 'Falha ao processar solicitação.'
        ], $code);
    }
}
