<?php

namespace App\Services\Empresa;

use App\Models\Empresa;
use App\Models\Empresa\AcessoPrefeitura;

class AcessoPrefeituraService
{
    public function getAcessosPrefeituraByEmpresaId(int $empresa_id)
    {
        $empresa = Empresa::withTrashed()->find($empresa_id);
        return $empresa->acessos_prefeituras()->get();
    }

    public function storeAcessoPrefeitura(array $data, int $empresa_id)
    {
        $empresa = Empresa::withTrashed()->find($empresa_id);
        return $empresa
            ->acessos_prefeituras()
            ->updateOrCreate(['tipo' => $data['tipo']], $data);
    }

    public function updateAcessoPrefeitura(array $data, int $id)
    {
        $acessoPrefeitura = AcessoPrefeitura::find($id);
        $acessoPrefeitura->fill($data)->save();
        return $acessoPrefeitura;
    }
}
