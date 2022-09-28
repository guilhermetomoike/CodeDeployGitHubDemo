<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlterarSenhaRequest;
use App\Http\Requests\ClienteStoreRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Http\Resources\ClienteResource;
use App\Http\Resources\EmpresaResource;
use App\Models\Cliente;
use App\Models\Contato;
use App\Models\Endereco;
use App\Services\ClienteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    private $service;

    public function __construct(ClienteService $clienteService)
    {
        $this->service = $clienteService;
    }

    public function index(Request $request)
    {
        $clientes = Cliente::paginate();

        return ClienteResource::collection($clientes);
    }

    public function store(ClienteStoreRequest $request)
    {
        $validated = $request->all();

        $cliente = $this->service->store($validated);

        return $cliente;
    }

    public function show(int $id)
    {
        $cliente = Cliente::findOrFail($id);
        return new ClienteResource($cliente);
    }

    public function search($search)
    {
        $clientes = $this->service->search($search);
        if (!$clientes) {
            return $this->noContent();
        }
        return ClienteResource::collection($clientes);
    }

    public function update(ClienteUpdateRequest $request, $id)
    {
        $updatedClient = $this->service->updateCliente($id, $request->validated());
        return new ClienteResource($updatedClient);
    }

    public function updateAvatar(Request $request, int $id)
    {
        $avatar = $request->file('avatar');
        $updatedClient = $this->service->updateAvatar($id, $avatar);
        return new ClienteResource($updatedClient);
    }

    public function updatePassword(AlterarSenhaRequest $request, int $id)
    {
        $data = $request->validated();
        try {
            $updatedClient = $this->service->alterarSenha($id, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
        return new ClienteResource($updatedClient);
    }
    public function resetPassword($id)
    {
         $this->service->resetPassword($id);

        return new JsonResponse(['msg' => 'Senha Resetada']);
    }


    public function destroy(int $id)
    {
        if (!$this->service->deleteCliente($id)) {
            return $this->badDependencyRequest('Registro não encontrado');
        }
        return $this->noContent();
    }

    public function empresas(int $id)
    {
        $empresas = Cliente::find($id)->empresa;
        return EmpresaResource::collection($empresas);
    }

    public function getClienteByToken()
    {
        return new ClienteResource(auth('api_clientes')->user());
    }

    public function getTokenByCliente(Cliente $cliente)
    {
        return Auth::guard('api_clientes')->login($cliente);
    }

    public function getAvatar(int $id)
    {
        $avatar = $this->service->getAvatar($id);

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($avatar);

        return response($avatar, 200, array(
            'Content-Type' => $mime,
        ));
    }

    public function addArquivo(Request $request, int $id)
    {
        $cliente = Cliente::find($id);
        return $cliente->addArquivo(
            $request['arquivo_id'],
            $request->tipo ?? $id,
            ['tipo' => $request['tipo']]
        );
    }
}
