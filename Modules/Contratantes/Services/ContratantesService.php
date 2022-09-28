<?php

namespace Modules\Contratantes\Services;

use App\Models\Endereco;
use Modules\Contratantes\Entities\Contratante;

class ContratantesService
{
    public function getAllContratantes()
    {
        return Contratante::all();
    }

    public function storeContratante(array $data)
    {
        $contratante = Contratante::create($data);

        $contratante->endereco()->create($data['endereco']);

        $email = $this->emailDataProvider($data['email']);
        $celular = $this->celularDataProvider($data['celular']);
        
        $contratante->contatos()->createMany([$celular, $email]);

        return $contratante;
    }

    public function updateContratante(array $data, Contratante $contratante)
    {
        $contratante->fill($data)->save();

        $contratante->refresh();

        $contratante->endereco()->first()->fill($data['endereco'])->save();

        $email = $this->emailDataProvider($data['email']);
        $celular = $this->celularDataProvider($data['celular']);

        $contratante->email->fill($email)->save();
        $contratante->celular->fill($celular)->save();

        return $contratante;
    }

    public function deleteContratante(Contratante $contratante)
    {
        $contratante->delete();
    }

    private function emailDataProvider(string $email) {
        return [
            'tipo' => 'email',
            'value' => $email,
            'optin' => true,
            'options' => [],
        ];
    }

    private function celularDataProvider(string $celular) {
        return [
            'tipo' => 'celular',
            'value' => $celular,
            'optin' => true,
            'options' => [
                'is_whatsapp' => true
            ],
        ];
    }
}
