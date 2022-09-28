<?php


namespace App\Services;


use App\Models\HistoricoRegimeTributario;

class HistoricoRegimeTributarioService
{
    public function getByEmpresaId(int $empresa_id)
    {
        return HistoricoRegimeTributario::query()->where('empresa_id', $empresa_id)->get();
    }

    public function create(array $data)
    {
        return HistoricoRegimeTributario::query()->create($data);
    }
}
