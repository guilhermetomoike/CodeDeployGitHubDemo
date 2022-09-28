<?php


namespace App\Repositories;


use App\Models\Empresa;
use App\Models\Prolabore;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class ProlaboreRepository
{
    public function createProlabore(int $empresa_id, $data_competencia, array $prolabore)
    {
        return Prolabore::query()->create([
            'clientes_id' => $prolabore['cliente_id'],
            'prolabore' => $prolabore['prolabore'],
            'data_competencia' => $data_competencia,
            'empresas_id' => $empresa_id,
        ]);
    }

    public function estornaLiberacaoProlabore(int $empresa_id, string $data_competencia)
    {
        return Prolabore::query()->where([
            'empresas_id' => $empresa_id,
            'data_competencia' => $data_competencia
        ])->delete();
    }

    public function getListaLiberacao(Request $request)
    {
        $data_competencia = $request->data_competencia;

        $result = Empresa::query()
            ->select('empresas.id', 'razao_social')
            ->where('saiu', 0)
            ->where('congelada', 0)
            ->where('regime_tributario', 'SN')
            ->whereNotNull('cnpj')
            ->with(['socios' => function (BelongsToMany $socio) {
                $socio->select('clientes.id', 'nome_completo');
            }]);

        if ($request->liberadas) {
            $result->whereRaw("empresas.id IN(SELECT empresas_prolabores.empresas_id FROM empresas_prolabores WHERE empresas_prolabores.empresas_id = empresas.id AND empresas_prolabores.data_competencia = '$data_competencia')");
        } else {
            $result->whereRaw("empresas.id NOT IN(SELECT empresas_prolabores.empresas_id FROM empresas_prolabores WHERE empresas_prolabores.empresas_id = empresas.id AND empresas_prolabores.data_competencia = '$data_competencia')");
        }

        if ($request->empresa_id) {
            $result->where('empresas.id', $request->empresa_id);
        }

        return $result->paginate();
    }
}
