<?php

namespace Modules\Activity\Http\Controllers;

use App\Models\Comentario;
use App\Models\ComentariosEtapasEmpresas;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Activity\Entities\Atividades;
use Modules\Activity\Entities\Etapas;
use Modules\Activity\Entities\EtapasEmpresas;

class EtapasEmpresasController extends Controller
{
    public function index()
    {

        return EtapasEmpresas::with('etapa')
            ->get();
    }
    public function listagem(Request $request)
    {
        try {
            $etapa = EtapasEmpresas::where('empresa_id', $request->empresas_id)->with('etapa')
                ->get();

            $atividade = Atividades::where('status_id', $request->status_id)->get();

            return response()->json(['etapas' => isset($etapa[0]) ? $this->progress($etapa) : $etapa, 'atividades' => $atividade], 200);
        } catch (Exception $e) {
            return response()->json($e . 'erro', 200);
        }
    }


    public function show($emp_id, $atv_id)
    {
        $etapas = Etapas::with('atividade')->where('empresa_id', $emp_id)->where('atividades_id', $atv_id)->get();
        $cont = 0;
        foreach ($etapas as $etapa) {



            if ($etapa->status == 1  && $cont == 0) {

                if (Carbon::now() > Carbon::parse($etapa->created_at)->addHour($etapa->tempo)) {
                    $etapa->status = 0;
                    $etapa->save();
                }
                $d1     =   new DateTime(Carbon::parse($etapa->created_at));

                $d2     =   new DateTime(Carbon::now());

                $horas = $d1->diff($d2, true);
                $etapa->progress =     ($horas->format('%H') / $etapa->tempo) * 100;
                $cont++;
                $etapa->con = 1;
            } else {
                Etapas::where('id', $etapa->id)->update(['created_at' => Carbon::now()]);
                $etapa->progress = 0;
                $etapa->con = 0;
            }
            if ($etapa->status == 2) {
                $etapa->progress = 100;
            }
        }
        return response()->json($etapas, 200);
    }

    public function store(Request $request)
    {
        $etapas =   Etapas::where('atividades_id', $request->atividade_id)->get();
        $cont = 0;
        foreach ($etapas as $etapa) {
            EtapasEmpresas::create([
                'status' => $etapa->status,
                'atividades_id' => $etapa->atividades_id,
                'empresa_id' => $request->empresas_id,
                'status' => $cont == 0 ? 1 : 4,
                'etapas_id' => $etapa->id,

            ]);

            $cont++;
        }


        return   $this->atividade_etapa($request->atividade_id, $request->empresas_id);
    }


    public function update(Request $request, $id)
    {

        $etapa = EtapasEmpresas::findOrFail($id);


        $etapa->finited = Carbon::now();
        $etapa->status = 2;
        // $etapa->update($data);
        $etapa->save();

        return   $this->atividade_etapa($etapa->atividades_id, $etapa->empresa_id);
    }


    public function atividade_etapa($atividades_id, $empresa_id)
    {
        $etapa = EtapasEmpresas::where('empresa_id', $empresa_id)->with('etapa')
            ->get();

        $atividade = Atividades::where('id', $atividades_id)->get();
        return response()->json(['etapas' => isset($etapa[0]) ? $this->progress($etapa) : $etapa, 'atividades' => $atividade], 200);
    }


    public function progress($etapas)
    {
        $cont = 0;


        foreach ($etapas as $etapa) {

            if ($etapa->status == 1) {
                if (empty($etapa->started)) {
                    EtapasEmpresas::where('id', $etapa->id)->update(['started' => Carbon::now()]);
                    $etapa->started =  Carbon::now();
                }

                if (Carbon::now() > Carbon::parse($etapa->started)->addHour($etapa->etapa->tempo)) {
                    $etapa->status = 0;
                    $etapa->save();
                }
                $d1     =   new DateTime(Carbon::parse($etapa->started));

                $d2     =   new DateTime(Carbon::now());

                $horas = $d1->diff($d2, true);
                $etapa->progress =   $horas->format('%H') == 0 ?  (($horas->format('%H') / $etapa->etapa->tempo) * 100) : 0;
                $cont++;
                $etapa->con = 1;
            } else if ($etapa->status == 4) {
                // return response()->json($etapa);
                if ($cont == 0) {
                    if (empty($etapa->started)) {

                        EtapasEmpresas::where('id', $etapa->id)->update(['started' => Carbon::now(), 'status' => 1]);
                        $etapa->started =  Carbon::now();
                        $etapa->status =  1;
                    }

                    // if (Carbon::now() > Carbon::parse($etapa->started)->addHour($etapa->etapa->tempo)) {
                    //     $etapa->status = 0;
                    //     $etapa->save();
                    // }
                    $d1     =   new DateTime(Carbon::parse($etapa->started));

                    $d2     =   new DateTime(Carbon::now());

                    $horas = $d1->diff($d2, true);
                    $etapa->progress =   $horas->format('%H') == 0 ?  (($horas->format('%H') / $etapa->etapa->tempo) * 100) : 0;
                    $cont++;
                    $etapa->con = 1;
                } else {
                    $etapa->progress = 0;
                    $etapa->con = 0;
                }
            }
            if ($etapa->status == 2) {
                $etapa->progress = 100;
            }
        }


        return $etapas;
    }


    public function comentar_etapa_empresa(Request $request)
    {


        $data = [
            'commentable_type'=>'empresa',
            'commentable_id'=>$request->empresas_id,
            'conteudo'=>$request->comentario,
            'usuario_id' => auth('api_usuarios')->id()
        ];
        
      $comentario =  Comentario::create($data);

        ComentariosEtapasEmpresas::create(['tipo'=>$request->tipo,'comentarios_id'=>$comentario->id,'etapas_empresas_id'=>$request->etapas_empresas_id]);
        return response()->json(['msg'=>'comentario criado com sucesso'],200);

    }

    public function comentarios_etapa_empresa($etapa_empresa_id)
    {
      $comentarios = ComentariosEtapasEmpresas::where('id',$etapa_empresa_id)->with('comentario')->first()->comentario;   
        return response()->json($comentarios,200);
    }
}
