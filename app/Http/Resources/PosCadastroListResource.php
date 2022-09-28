<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PosCadastroListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $socioAdm = $this->socioAdministrador;

        return [

            'id' => $this->id,
            'id_socio_administrador' => $socioAdm->count() ? $socioAdm[0]->pivot->clientes_id : null,
            'nome_socio_administrador' => $socioAdm->count() ? $socioAdm[0]->nome_completo : null,
            'razao_social' => $this->razao_social,
            'nome_fantasia' => $this->nome_fantasia,
            'status_id' => $this->status_id,
            'status_label' => $this->status_label,
            'precadastro_tipo' => $this->precadastro ? $this->precadastro['tipo'] : null,
            'carteiras'=> $this->carteirasrel
        ];
    }
}
