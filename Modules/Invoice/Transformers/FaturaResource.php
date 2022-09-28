<?php

namespace Modules\Invoice\Transformers;
use App\Models\Empresa;
use Illuminate\Http\Resources\Json\JsonResource;

class FaturaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $contrato = $this->payer && $this->payer->contrato ? $this->payer->contrato : false;
    
        return [
            'id' => $this->id,
            // 'carteiras' => $this->payer->carteirasrel ?? null,
            'payer_id' => $this->payer ? $this->payer->id : null,
            'payer_type' => $this->payer_type,
            'payer_name' => $this->payer ? $this->payer->getName() : null,
            'subtotal' => $this->subtotal,
            'forma_pagamento' => ($this->forma_pagamento_id === 2) ? 'Cartão' : (($this->forma_pagamento_id === 1) ? 'Boleto' : 'PIX'),
            'forma_pagamento_id' => $this->forma_pagamento_id,
            'data_competencia' => $this->data_competencia,
            'data_vencimento' => $this->data_vencimento,
            'data_recebimento' => $this->data_recebimento,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'fatura_url' => $this->fatura_url,
            'pix_qrcode_text' => $this->pix_qrcode_text,
            'arquivo' => $this->arquivo,
            'contrato' => $contrato ? $contrato : null,
            'em_conjunto' => $this->em_conjunto,
            'tipo_cobrancas_id' => $this->tipo_cobrancas_id,
            'items'=> isset($this->items[0])  ?   $this->items : $this->movimento ,
       
            
            
        ];
    }
}
