<?php

namespace Modules\Plans\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Plans\Entities\PlansIntervalType;
use Modules\Plans\Entities\PlansPayableWith;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'type' => $this->type,
            'interval_type' => (string)new PlansIntervalType($this->interval_type),
            'interval' => $this->interval_type,
            'payable_with' => (string)new PlansPayableWith($this->payable_with),
        ];
    }
}
