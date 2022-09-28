<?php

namespace Modules\Activity\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Activity\Entities\Atividades;
use Modules\Activity\Entities\Etapas;

class EtapasController extends Controller
{
    public function index()
    {
        try {
            //code...
      
        $atividade = Etapas::with('atividade')
            ->get();

        return response()->json($atividade, 200);
    } catch (Exception $e) {
       return response()->json($e .'erro',200);
    }
    }

    public function show($id)
    {
        $etapas = Etapas::with('atividade')->where('atividades_id', $id)->get();
        // $cont = 0;
        foreach ($etapas as $etapa) {
         
                $etapa->progress = 0;
                $etapa->con = 0;
            
        
        }
        return response()->json($etapas, 200);
    }

    public function store(Request $request)
    {
        $arrayEtapa = $request->all();
        $arrayEtapa['status'] = 1;
        $etapa = Etapas::create($arrayEtapa);
        

        return response()->json(['msg' => 'criado com sucesso', 'conteudo' => $etapa], 200);
    }
    public function update(Request $request, $id)
    {

        $etapa = Etapas::findOrFail($id);

        $etapa->update($request->all());
        $etapa->save();

        return response()->json(['msg' => 'atualizado com suceso', 'conteudo' => $etapa], 200);

    }

    public function destroy($id)
    {
        $etapas = Etapas::findOrFail($id);
        $etapas->delete();

        return response()->json([], 200);
    }
}
