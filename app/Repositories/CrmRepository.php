<?php

namespace App\Repositories;

use App\Models\Crm;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;

class CrmRepository
{
    public function getCrmAppropriatedForBillingByEmpresa(Empresa $empresa): ?Model
    {
        $idSocios = $empresa->socios()->pluck('id');
        $crmPf = Crm::query()
            ->where('owner_type', 'cliente')
            ->whereIn('owner_id', $idSocios)
            ->orderBy('data_emissao', 'desc')
            ->first();

        if ($crmPf) {
            return $crmPf;
        }

        return Crm::query()
            ->where('owner_type', 'empresa')
            ->where('owner_id', $empresa->id)
            ->first();
    }
    public function getCrmAppropriatedByEmpresa(Empresa $empresa): ?Model
    {
     

        return Crm::query()
            ->where('owner_type', 'empresa')
            ->where('owner_id', $empresa->id)
            ->first();
    }
}

