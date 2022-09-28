<?php

namespace Modules\Apontamentos\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ApontamentosResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'sla' => $this->sla
        ];
    }
}
