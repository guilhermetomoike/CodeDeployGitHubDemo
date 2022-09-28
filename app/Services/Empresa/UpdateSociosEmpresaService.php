<?php

namespace App\Services\Empresa;

use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class UpdateSociosEmpresaService
{
    public function execute(Empresa $empresa, array $socios)
    {
        $sociosToAttach = collect($socios)
            ->mapWithKeys(function ($socio) {
                return [$socio['cliente_id'] => [
                    'porcentagem_societaria' => $socio['porcentagem_societaria'],
                    'socio_administrador' => $socio['socio_administrador'],
                ]];
            })
            ->toArray();

        try {
            DB::beginTransaction();
            $empresa->socios()->detach();
            $empresa->socios()->attach($sociosToAttach);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
}
