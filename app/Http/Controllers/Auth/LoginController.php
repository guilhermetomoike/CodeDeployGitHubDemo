<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClienteResource;
use App\Http\Resources\EmpresaWithStatusResouce;
use App\Http\Resources\UsuariosResource;
use App\Models\Empresa;
use App\Services\AppSettingsService;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $authService;
    private AppSettingsService $appSettingsService;

    public function __construct(AuthService $authService, AppSettingsService $appSettingsService)
    {
        $this->authService = $authService;
        $this->appSettingsService = $appSettingsService;
    }

    public function loginCliente(Request $request)
    {
        $this->validate($request, [
            'cpf' => 'required|string|max:80',
            'senha' => 'required|string|max:80',
        ]);

        $cliente = $this->authService->attemptCredentialsCliente($request->all());

        foreach ($cliente->empresa as $empresa) {
            $this->appSettingsService
                ->createOrUpdatedAccess('empresa', $empresa->id);
        }

        $token = auth('api_clientes')->login($cliente);

        $this->appSettingsService->createOrUpdatedAccess('cliente', $cliente->id);

        return response([
            'token' => $token,
            'cliente' => new ClienteResource($cliente),
            'empresas' => EmpresaWithStatusResouce::collection($cliente->empresa),
        ]);
    }

    public function loginUsuario(Request $request)
    {
        $this->validate($request, [
            'usuario' => 'required|string|max:80',
            'senha' => 'required|string|max:80',
        ]);

        $usuario = $this->authService->attemptCredentialsUsuario($request->all());

        $token = Auth::guard('api_usuarios')->login($usuario);

        return response([
            'token' => $token,
            'usuario' => new UsuariosResource($usuario),
        ]);
    }

    public function refresh()
    {
        if ($usuario = auth('api_usuarios')->user()) {
            return response([
                'token' => auth('api_usuarios')->refresh(),
                'usuario' => new UsuariosResource($usuario),
            ]);
        }

        $cliente = auth('api_clientes')->user();

        foreach ($cliente->empresa as $empresa) {
            $this->appSettingsService
                ->createOrUpdatedAccess('empresa', $empresa->id);
        }

        $this->appSettingsService->createOrUpdatedAccess('cliente', $cliente->id);
        return response([
            'token' => auth('api_clientes')->refresh(),
            'cliente' => new ClienteResource($cliente),
            'empresas' => EmpresaWithStatusResouce::collection($cliente->empresa),
        ]);
    }

    public function verifyToken()
    {
        return;
    }

}
