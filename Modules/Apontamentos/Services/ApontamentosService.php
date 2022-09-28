<?php

namespace Modules\Apontamentos\Services;
use Modules\Apontamentos\Entities\Apontamento;

class ApontamentosService
{
    public function getAllApontamentos()
    {
        return Apontamento::all();
    }

    public function storeApontamento(array $data)
    {
        return Apontamento::create($data);
    }

    public function updateApontamento(array $data, Apontamento $apontamento)
    {
        return $apontamento->fill($data)->save();
    }

    public function deleteApontamento(Apontamento $apontamento)
    {
        $apontamento->delete();
    }
}
