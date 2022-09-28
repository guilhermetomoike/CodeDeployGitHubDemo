<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class SocioProlaboreAtualAnteriorResource extends JsonResource
{
    public function toArray($request)
    {
        $competenciaAtual = $request->get('competencia');
        $competenciaAnterior = Carbon::parse($request->get('competencia'))->subMonth();
        $prolaboreAtual = $this->prolabore()->where('data_competencia', $competenciaAtual)->first();
        $prolaboreAnterior = $this->prolabore()->where('data_competencia', $competenciaAnterior)->first();
        return [
            'id' => $this->id,
            'nome' => $this->nome_completo,
            'prolabore_atual' => $prolaboreAtual->prolabore ?? 0,
            'prolabore_anterior' => $prolaboreAnterior->prolabore ?? 0,
        ];
    }
}
