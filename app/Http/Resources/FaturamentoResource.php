<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FaturamentoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'faturamento' => "R$ " . number_format($this->faturamento, 2, ',', '.'),
            'mes' => Carbon::parse($this->mes)->format('m/Y'),
            'previsao' => $this->previsao ?? false,
        ];
    }
}
