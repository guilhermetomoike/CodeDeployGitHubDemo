<?php


namespace App\Services;


use App\Models\Cliente;
use App\Models\IrpfAssets;

class AssetsService
{

    public function getAllBYIrpfId($irpfId)
    {
        return IrpfAssets::query()->firstWhere('irpf_id', $irpfId);
    }

    public function store($data)
    {
        return Cliente::findOrFail($data['client_id'])->irpf()->first()->assets()->create($data);
    }

    public function update($data, $id)
    {
        $irpf = IrpfAssets::findOrFail($id);
        $irpf->fill($data);
        $irpf->save();

        return $irpf;
    }

    public function destroy($id)
    {
        return IrpfAssets::destroy($id);
    }
}
