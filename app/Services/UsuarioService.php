<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsuarioService
{

    public function getUsuarios($request)
    {
        return Usuario::all();
    }

    public function deleteUsuario(int $id): bool
    {
        if (!Usuario::find($id)) {
            return false;
        }
        DB::transaction(function () use ($id) {
            Usuario::findOrFail($id)->delete();
        });
        return true;
    }

    public function update(int $id, array $data)
    {
        $user = Usuario::query()->find($id);

        if (isset($data['role'])) {
            $user->syncRoles($data['role']);
            $user->syncPermissions($data['permissions'] ?? []);
        }

        if ($data['senha'] ?? false) {
            $this->alterarSenha($user, $data);
        }
        unset($data['senha']);

        $user->update($data);

        return $user;
    }

    public function alterarSenha($user, array $data)
    {
        if ($user->senha != md5($data['senha_atual'])) {
            abort(400, 'Senha atual incorreta.');
        }

        return $user->update([
            'senha' => $data['senha']
        ]);
    }

    public function updateAvatar(int $id, ?UploadedFile $avatar)
    {
        $data['avatar'] = Storage::disk('s3')->put('avatar', $avatar);
        $usuario = Usuario::find($id);
        $usuario->update($data);
        return $usuario->fresh();
    }

    public function getAvatar(int $id)
    {
        $avatar = null;
        $usuario = Usuario::find($id);
        if ($usuario && $usuario->avatar) {
            $avatar = Storage::disk('s3')->get($usuario->avatar);
        }
        if (!$avatar) {
            $avatar = Storage::disk('public')->get('default_avatar.png');
        }
        return $avatar;
    }

    public function restore(int $id)
    {
        return Usuario::withTrashed()->find($id)->restore();
    }
}
