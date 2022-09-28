<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->saiu || $this->trashed()) {
            $status = 'desativada';
        } else if ($this->congelada) {
            $status = 'congelada';
        } else if ($this->status_id == 70) {
            $status = 'desativacao_agendada';
        } else if ($this->status_id < 100) {
            $status = 'abertura';
        } else {
            $status = 'normal';
        }
        if($this->residencia_medica ? true : false){
            $status = 'residencia';
        }

        return [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'cnpj' => $this->cnpj,
            'regime_tributario' => $this->regime_tributario,
            'status' => $status,
        ];
    }
}
