<?php

namespace Modules\Contratantes\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ContratanteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'endereco' => [
                'iptu' => $this->endereco->iptu,
                'cep' => $this->endereco->cep,
                'logradouro' => $this->endereco->logradouro,
                'numero' => $this->endereco->numero,
                'complemento' => $this->endereco->complemento,
                'bairro' => $this->endereco->bairro,
                'cidade' => $this->endereco->cidade,
                'uf' => $this->endereco->uf,
                'ibge' => $this->endereco->ibge,
            ],
            'email' => $this->email->value,
            'celular' => $this->celular->value
        ];
    }
}
