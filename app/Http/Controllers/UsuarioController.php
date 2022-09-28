<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseConsultaRequest;
use App\Http\Requests\UsuarioSaveRequest;
use App\Http\Resources\UsuariosResource;
use App\Models\Usuario;
use App\Services\UsuarioService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    private UsuarioService $service;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->service = $usuarioService;
    }

    public function index(Request $request)
    {
        $searchNome = $request->get('nome', null);
        $usuarios = Usuario::withTrashed()->with(['roles', 'permissions']);
        if ($searchNome) {
            $usuarios = $usuarios->where('nome_completo', 'like', "%$searchNome%");
        }
        return UsuariosResource::collection($usuarios->get());
    }

    public function store(Request $request)
    {
//        $this->authorize('cadastrar usuario');
        $user = Usuario::create($request->all());
        $user->assignRole($request->post('roles'));

        return $this->successResponse();
    }

    /**
     * @param Usuario $usuario
     * @return UsuariosResource
     * @throws AuthorizationException
     */
    public function show(Usuario $usuario)
    {
//        $this->authorize('ver usuario');

        return new UsuariosResource($usuario);
    }

    /**
     * Atualiza usuarios com permissions and roles
     * @param Request $request
     * @param int $id
     * @return UsuariosResource
     */
    public function update(Request $request, int $id)
    {
        $user = $this->service->update($id, $request->all());
        return new UsuariosResource($user);
    }

    public function destroy(int $id)
    {
//        $this->authorize('deletar usuario');

        if (!$this->service->deleteUsuario($id)) {
            return $this->badDependencyRequest('Registro não encontrado');
        }

        return $this->noContent();
    }

    public function getTipoUsuario()
    {
        $roles = Role::all()->toArray();
        return response($roles);
    }

    public function getUserByToken()
    {
        return new UsuariosResource(auth('api_usuarios')->user());
    }

    public function updateAvatar(Request $request, int $id)
    {
        $avatar = $request->file('avatar');
        $updatedUser = $this->service->updateAvatar($id, $avatar);
        return new JsonResponse($updatedUser);
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

    public function restore(int $id)
    {
        $restored = $this->service->restore($id);
        if (!$restored) {
            return new JsonResponse(['message' => 'Erro ao restaurar o usuário'], 400);
        }
        return new JsonResponse(['message' => 'Usuário restaurado com sucesso!']);
    }
}

