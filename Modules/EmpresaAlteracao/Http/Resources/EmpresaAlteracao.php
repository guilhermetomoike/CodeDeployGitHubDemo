<?php

namespace Modules\EmpresaAlteracao\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaAlteracao extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'empresa' => $this->empresa,
            'status_id' => $this->status_id,
            'status_label' => $this->status_label,
            'solicitacao' => $this->solicitacao,
            'alteracao' => $this->alteracao,
        ];
    }
}
