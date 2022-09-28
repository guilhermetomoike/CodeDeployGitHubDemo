<?php

namespace App\Models\Nfse;

use Illuminate\Database\Eloquent\Model;

class TomadorNfse extends Model
{
    protected $table = 'tomador_nfse';

    protected $fillable = [
        'cpf_cnpj', 'razao_social', 'nome_fantasia', 'email', 'tipo_logradouro', 'logradouro', 'numero', 'complemento',
        'bairro', 'codigo_cidade', 'descricao_cidade', 'estado', 'cep',
    ];

    public function isCadastroCompleto()
    {
        return $this->cpf_cnpj && $this->razao_social && $this->codigo_cidade && $this->estado && $this->cep;
    }
}
