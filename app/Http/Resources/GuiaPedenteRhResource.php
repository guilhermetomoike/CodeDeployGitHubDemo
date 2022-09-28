<?php

namespace App\Http\Resources;

use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GuiaPedenteRhResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $competencia = Carbon::createFromFormat('m-Y', $request->competencia);

        return[
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'regime_tributario' => $this->regime_tributario,
            'socio' => $this->mapSocioWithProlabore($competencia)->toArray(),
        ];

    }

    public function mapSocioWithProlabore($competencia)
    {
        $competenciaAtual = $competencia->format('Y-m-1');
        $competenciaAnterior = $competencia->subMonth()->format('Y-m-1');

        $socio = $this->socios()->get(['nome_completo']);

        $socio->map(function (Cliente $socio) use ( $competenciaAnterior, $competenciaAtual) {

            $prolaboreAtual = $socio->prolabore()
                ->where('data_competencia', $competenciaAtual)
                ->where('empresas_id', $this->id)
                ->first();

            $prolaboreAnterior = $socio->prolabore()
                ->where('data_competencia', $competenciaAnterior)
                ->where('empresas_id', $this->id)
                ->first();

            $socio['prolabore_atual'] = $prolaboreAtual->prolabore ?? 0;
            $socio['prolabore_anterior'] = $prolaboreAnterior->prolabore ?? 0;

            return $socio->toArray();
        });
    }
}
