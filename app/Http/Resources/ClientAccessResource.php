<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientAccessResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'password' => $this->password,
            'type' => $this->type,
            'url' => $this->url
        ];
    }
}
