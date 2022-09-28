<?php

namespace Modules\Irpf\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class IrpfClientesListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome_cliente' => $this->nome_completo,
            'empresa' => $this->empresa->implode('id', ', '),
            'irpf' => $this->irpf,
            'carteiras' => $this->empresa->map(fn($empresa) => $empresa->carteiras)->flatten(),
            'contratos' => $this->empresa->map(fn($empresa) => $empresa->contrato),
        ];
    }
}
