<?php


namespace App\Repositories;


use App\Models\Nfse\TomadorNfse;

class TomadorRepository
{
    public function getByCnpj($cnpj)
    {
        return TomadorNfse::whereCpfCnpj(only_numbers($cnpj))->first()->toArray();
    }
}