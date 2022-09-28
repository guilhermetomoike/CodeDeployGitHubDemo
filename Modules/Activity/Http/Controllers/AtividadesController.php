<?php

namespace Modules\Activity\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Activity\Entities\Atividades;

class AtividadesController extends Controller
{
    public function index()
    {
        $atividade = Atividades::
            get();

        return response()->json($atividade, 200);
    }

    public function show($id)
    {
        return response()->json(Atividades::findOrFail($id), 200);
    }


    public function store(Request $request)
    {


        $atividade = Atividades::create($request->all());


        return response()->json(['message' => 'criado com sucesso', 'conteudo' => $atividade], 200);
    }
    public function update(Request $request, $id)
    {

        $activity = Atividades::findOrFail($id);

        $activity->update($request->all());
        $activity->save();

        return response()->json('atualizado com suceso', 200);
    }

    public function destroy($id)
    {
        $activity = Atividades::findOrFail($id);
        $activity->delete();

        return response()->json([], 200);
    }
}
