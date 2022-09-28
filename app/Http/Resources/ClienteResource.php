<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClienteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome_completo' => $this->nome_completo,
            'email' => $this->email,
            'avatar' => $this->getAvatarUrl(),
            'sexo' => $this->sexo,
            'acessouApp' => $this->acessou_app,
            'cpf' => $this->cpf,
            'acessou_web' => $this->acessou_web,
            'data_nascimento' => $this->data_nascimento,
            'idade' => Carbon::parse($this->data_nascimento)->age,
            'profissao' => $this->profissao,
            'nacionalidade' => $this->nacionalidade,
            'naturalidade' => $this->naturalidade,
            'rg' => $this->rg,
            'pis' => $this->pis,
            'prolabore_fixo' => $this->prolabore_fixo === 1,
            'percentual_prolabore' => $this->percentual_prolabore,
            'valor_prolabore_fixo' => $this->valor_prolabore_fixo,
            'app_info' => [
                'created_at' => $this->appSettings ? $this->appSettings->created_at : null,
                'last_access' => $this->appSettings ? $this->appSettings->last_access : null,
                'updated_contact' => $this->appSettings ? $this->appSettings->updated_contact : null,
                'updated_course' => $this->appSettings ? $this->appSettings->updated_course : null,
            ],
            'porcentagem_societaria' => $this->porcentagem_societaria,
            'socio_administrador' => $this->socio_administrador,
            'course' => $this->course,
            'estado_civil' => $this->estado_civil,
            'qualificacao' => $this->qualificacao()->first(),
            'especialidade' => $this->especialidade()->first(),
        ];
    }
}
