<?php

namespace Modules\EmpresaAlteracao\Services;

use App\Models\Empresa;
use Modules\EmpresaAlteracao\Entities\EmpresaAlteracao;
use Modules\EmpresaAlteracao\Http\Requests\EmpresaAlteracaoStoreRequest;

class EmpresaAlteracaoService
{
    public function create(EmpresaAlteracaoStoreRequest $request)
    {
        $empresaAlteracao = $this->cleanData($request->validated());
        $empresaAlteracao['status_id'] = 1;
        $empresaAlteracao['alteracao'] = $this->buildEmpresaStructure($empresaAlteracao['empresa_id']);

        return EmpresaAlteracao::create($empresaAlteracao);
    }

    private function buildEmpresaStructure(int $empresaId)
    {
        $empresa = Empresa::find($empresaId);

        $structure = [
            'empresa' => [
                'id' => $empresa->id,
                'nome_empresa' => $empresa->nome_empresa,
                'razao_social' => $empresa->razao_social,
                'nome_fantasia' => $empresa->nome_fantasia,
                'regime_tributario' => $empresa->regime_tributario,
                'tipo_societario' => $empresa->tipo_societario,
                'clinica_fisica' => $empresa->clinica_fisica,
            ],
            'socios' => $empresa->socios->toArray(),
            'endereco' => $empresa->endereco->toArray(),
            'contatos' => $empresa->contatos->toArray(),
        ];

        return $structure;
    }

    private function cleanData($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->cleanData($data[$key]);
            }

            if (empty($data[$key])) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
