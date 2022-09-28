<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\ActivitySchedule;
use App\Models\ActivityLog;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{

    public function LogsForUsers(Request $request)
    {

        //1 Modules\Invoice\Entities\Fatura
        //2 App\Models\Arquivo
        //3 empresa_alvara
        //4 empresa
        //5 empresa_pre_cadastro
        //6 guia
        //7 App\Models\GuiaLiberacao
        //8 App\Models\Contato
        //9 App\Models\Upload
        //10 App\Models\Crm
        //11 App\Models\ViabilidadeMunicipal
        //12 Modules\\LivroFiscal\\Entities\\LivroFiscal
        //13 App\\Models\\ClienteCourse
        //14 App\\Models\\Nfse\\Nfse 
        // $request->subject_type;
        $data =[];
        $logs =    ActivityLog::query()
        ->join('usuarios', 'usuarios.id', 'activity_log.causer_id')
        ->where('activity_log.created_at', '>=', $request->data_inicio)
        ->where('activity_log.created_at', '<=', $request->data_fim)
        // ->where('activity_log.causer_id',$request->usuario)

        ->where('activity_log.causer_id', ($request->usuario  == "" ? "<>":"="),$request->usuario)
       
        ->where('activity_log.subject_type', ($request->subject_type  == "" ? "<>":"="),$request->subject_type)
            
    
        ->where('causer_id', '>', 0)
            ->select('activity_log.*', 'usuarios.nome_completo')->get();

        foreach ($logs as $item) {
            $data[] = ['id' => $item->id, 'description' => $item->description, 'causer_id' => $item->causer_id, 'nome_completo' => $item->nome_completo, 'properties' => json_decode($item->properties)];
        }

        return $data;
    }

    public function pegarSubjectType()
    {
        try {
        return ActivityLog::query()->groupBy('subject_type')->select('subject_type')->where('causer_id', '>', 0)->get();
            
        } catch (Exception $th) {
        return $th;
        }
    }
}
