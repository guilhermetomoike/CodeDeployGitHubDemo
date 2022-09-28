<?php

namespace Modules\Irpf\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class IrpfPendenciasResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'nome' => $this[0]->nome,
            'irpf_questionario_id' => $this[0]->irpf_questionario_id,
            'declaracao_irpf_id' => $this[0]->declaracao_irpf_id,
            'irpf_pendencia_id' => $this[0]->irpf_pendencia_id,
            'descricao' => $this[0]->descricao ?? '',
            'pendencias' => $this->resource->transform(fn($pendencia) => [
                'id' => $pendencia->id,
                'temPendencia' => $pendencia->temPendencia,
                'inputs' => $pendencia->inputs,
            ])
        ];
    }
}
