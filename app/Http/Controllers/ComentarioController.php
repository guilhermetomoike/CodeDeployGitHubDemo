<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComentarioStoreRequest;
use App\Http\Requests\ComentarioUpdateRequest;
use App\Models\Comentario;
use Modules\Activity\Entities\Atividades;
use Modules\Activity\Entities\Etapas;

class ComentarioController extends Controller
{
    public function index($commentable_type, $commentable_id)
    {
        return Comentario::commentable($commentable_type, $commentable_id)
            ->with('usuario:id,nome_completo')
            ->latest()
            ->get();
    }

    public function store(ComentarioStoreRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = auth('api_usuarios')->id();
        // if (isset(etapas::where('empresa_id', $data['commentable_id'])->first()->id)) {
        //     $data['etapas_id'] = Etapas::where('status', 1)->where('atividades_id', Atividades::where('empresa_id', $data['commentable_id'])->first()->id)->first()->id;
        // }
        return Comentario::create($data);
    }

    public function update(ComentarioUpdateRequest $request, Comentario $comentario)
    {
        $comentario->fill($request->validated())->save();
        return $comentario;
    }

    public function destroy(Comentario $comentario)
    {
        $comentario->delete();
        return response()->noContent();
    }
}
