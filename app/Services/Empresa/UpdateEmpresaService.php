<?php

namespace App\Services\Empresa;

use App\Models\Carteira;
use App\Models\Contato;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Services\HistoricoRegimeTributarioService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UpdateEmpresaService
{
    public function execute(int $id, array $data)
    {
        $empresa = Empresa::find($id);
        $empresa->update($data);

        if (isset($data['regimeTributario']) && !empty($data['regimeTributario'])) {
            (new HistoricoRegimeTributarioService())->create([
                'empresa_id' => $id,
            ] + $data['regimeTributario']);
        }

        return $empresa;
    }
}
