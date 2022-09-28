<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaWithContratoResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'contrato' => $this->contrato,
            'status_id' => $this->status_id,
        ];
if(isset($this->contrato->extra)){
        if ($this->contrato->extra && is_null($this->contrato->signed_at)) {
            $token = auth('api_clientes')->login($this->socioAdministrador[0]);
            $link = "https://cliente.medb.com.br/assinar-contrato?token={$token}&empresaId={$this->id}";
            $data['link'] = $link;
            $data['request_signature_key'] = $this->contrato->extra['clicksign']['request_signature_key'];
        }}

        return $data;
    }
}
