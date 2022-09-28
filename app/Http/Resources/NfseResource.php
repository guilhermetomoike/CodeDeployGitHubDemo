<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NfseResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "fatura_id" => $this->fatura_id,
            "id_integracao" => $this->id_tecnospeed,
            "tomador" => $this->razao_social ?? $this->tomador,
            "valor_nota" => $this->valor_nota,
            "status" => $this->status,
            "arquivo" => $this->arquivo_nfse,
            "data_emissao" => $this->emissao,
            "mensagem_retorno" => $this->mensagem_retorno,
            "created_at" => $this->created_at,
        ];
    }

}
