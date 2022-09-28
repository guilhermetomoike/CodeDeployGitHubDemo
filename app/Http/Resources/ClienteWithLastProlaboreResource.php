<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteWithLastProlaboreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data_competencia_anterior = Carbon::parse($request->data_competencia)->subMonth()->format('Y-m-01');
        $ultimo_prolabore = $this
            ->prolabore()
            ->whereDataCompetencia($request->liberadas ? $request->data_competencia : $data_competencia_anterior)
            ->whereEmpresasId($this->pivot->empresas_id)
            ->first();

        return [
            'id' => $this->id,
            'nome_completo' => $this->nome_completo,
            'ultimo_prolabore' => $ultimo_prolabore ? $ultimo_prolabore->prolabore : null
        ];
    }
}
