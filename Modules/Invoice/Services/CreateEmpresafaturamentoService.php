<?php

namespace Modules\Invoice\Services;

use App\Models\Faturamento;
use Modules\Invoice\Entities\Fatura;
use App\Services\Recebimento\RecebimentoService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateEmpresafaturamentoService
{

    public function create($faturamento)
    {

           $fatura = Faturamento::create($faturamento)->id;

            return 'criado com sucesso'.$fatura;
        
    }
}
