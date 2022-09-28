<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdemServicoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $qtd_atividade_concluida = $this->atividades->where('status', 'concluido')->count();
        $qtd_atividades = $this->atividades->count();

        if ($qtd_atividade_concluida > 0 && $qtd_atividades > 0) {
            $percentual_concluido = ($qtd_atividade_concluida * 100) / $qtd_atividades;
        } else {
            $percentual_concluido = 0;
        }

        return [
            'id' => str_pad($this->id, 5, '0', STR_PAD_LEFT),
            'empresa_id' => $this->empresa_id,
            'empresa' => $this->empresa_id . ' - ' . $this->razao_social,
            'data_limite' => $this->items->first()->data_limite->format('d/m/Y'),
            'progresso' => $percentual_concluido,
            'setores' => $this->items->unique('setor')->pluck('setor'),
            'responsavel' => $this->usuario ? $this->usuario->getFirstName() : null,
            'created_at' => $this->created_at->format('d/m/Y H:i'),
        ];
    }
}
