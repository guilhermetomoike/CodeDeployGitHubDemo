<?php

namespace App\Http\Resources;

use App\Models\Prolabore;
use App\Services\Simulador\SimulatorService;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientePgblResource extends JsonResource
{
    /**
     * @var SimulatorService
     */
    private $simulador;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->simulador = new SimulatorService();
    }

    public function toArray($request)
    {
        $prolabores = Prolabore::getBySociosId([$this->resource->id]);

        $simulacao = $this->simulador->Pgbl->simulate($prolabores);

        return [
            'empresas_id' => $this->resource->empresa->pluck('id'),
            'cliente_id' => $this->resource->id,
            'cliente_nome' => $this->resource->nome_completo,
            'faturamento' => formata_moeda($simulacao['renda_anual_s'] ?? 0, true),
            'aplicacao' => formata_moeda($simulacao['valor_aplicado'] ?? 0, true) ,
            'economia' => formata_moeda($simulacao['economia'] ?? 0, true),
            'pre_queued' => boolval($this->resource->pre_queued),
            'dispatched_at' => $this->resource->dispatched_at,
        ];
    }
}
