<?php


namespace App\Repositories;


use App\Models\Cliente;
use phpDocumentor\Reflection\Types\Integer;

class AssetsRepository
{
    public function getAssetsByClient($client_id)
    {
        return Cliente::findOrFail($client_id)
            ->irpf()->first()->assets ?? [];
    }
}
