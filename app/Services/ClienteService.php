<?php

namespace App\Services;


use App\Models\Cliente;
use App\Models\ClientePlano;
use App\Models\Contato;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Repositories\ClienteRepository;
use App\Services\Cliente\AccessService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Predis\Protocol\Text\Handler\ErrorResponse;

class ClienteService
{
    private ClienteRepository $repository;
    private AccessService $accessService;

    public function __construct(ClienteRepository $repository, AccessService $accessService)
    {
        $this->repository = $repository;
        $this->accessService = $accessService;
    }

    public static function sendDadosAcessoByWappNumber($numero)
    {
        $empresas = Empresa::query()
            ->select('empresas.id')
            ->whereRaw("empresas.id in (SELECT empresas_emails.empresas_id FROM empresas_emails
            WHERE empresas_emails.whatsapp = '$numero')")
            ->first();

        $empresas->getSocios->each(function (Cliente $cliente) {
            $cliente->update(['senha' => $cliente->cpf]);
        });

        TwilioService::message($numero, "Seu login e senha é o número de seu cpf. Recomendamos alterar a senha no primeiro login.\nAcesse https://cliente.medb.com.br e cadastre-se");
    }

    public function store(array $validated)
    {
        $data = $validated['cliente'];
        $contatos = Contato::find($validated['contatos']);
        $endereco = Endereco::find($validated['endereco_id']);
        $arquivos = $validated['arquivos'];

        try {
            DB::beginTransaction();

            $cliente = Cliente::create($data);
            $this->validadeAccess($cliente, $data);
            $cliente->contatos()->saveMany($contatos);

            if (!empty($data['ies_id'])) {
                $cliente->course()->create(['ies_id' => $data['ies_id']]);
            }

            if (!empty($validated['plan_id'])) {
                $cliente->plans()->sync($validated['plan_id']);
            }

            $cliente->endereco()->save($endereco);
            foreach ($arquivos as $key => $arquivo) {
                if (!$arquivo) continue;
                $cliente->addArquivo($arquivo, str_replace('_id', '', $key));
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($cliente);
    }

    public function validadeAccess(Cliente $cliente, array $data)
    {
        if (!empty($data['url']) && !empty($data['login']) && !empty($data['password'])) {
            $data['type'] = 'inss';
            return $this->accessService->store($data, $cliente->id);
        }

        return null;
    }

    public function getClientes($request)
    {
        $clientesIdsPlanos = ClientePlano::all()->pluck('clientes_id')->unique();
        $search = $request->get('search', '');

        return Cliente::query()->whereIn('id', $clientesIdsPlanos)
            ->where('nome_completo', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orderBy('nome_completo');
    }

    public function updateCliente(int $id, array $data)
    {
        return $this->repository->updateCliente($id, $data);
    }

    public function alterarSenha(int $id, array $data)
    {
        if ($this->repository->find($id)->senha != md5($data['senha_atual'])) {
            abort(400, 'Senha atual incorreta.');
        }

        return $this->repository->updateCliente($id, $data);
    }
    public function resetPassword($id)
    {

        
    
        return $this->repository->resetSenha($id, ['senha' => md5($this->repository->find($id)->cpf)]);
    }


    public function updateAvatar(int $id, $avatar)
    {
        $data['avatar'] = Storage::disk('s3')->put('avatar', $avatar);
        return $this->repository->updateCliente($id, $data);
    }

    public function deleteCliente(int $id): bool
    {
        return Cliente::destroy($id);
    }

    public function search($search)
    {
        if (strlen($search) < 4) return null;

        return $this->repository->search($search);
    }

    public function getAvatar(int $id)
    {
        $avatar = null;
        $cliente = $this->repository->find($id);
        if ($cliente && $cliente->avatar) {
            $avatar = Storage::disk('s3')->get($cliente->avatar);
        }
        if (!$avatar) {
            $avatar = Storage::disk('public')->get('default_avatar.png');
        }
        return $avatar;
    }
}
