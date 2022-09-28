<?php

namespace App\Repositories;

use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class EmpresaRepository
{
    public function updateAcessoNfse(int $empresa_id, array $data)
    {
        return DB::table('empresas_acessos')->updateOrInsert(
            ['empresas_id' => $empresa_id], $data
        );
    }

    public function updateContaBancaria(int $empresa_id, array $data)
    {
        return DB::table('contas_bancarias')->updateOrInsert(
            ['empresas_id' => $empresa_id], $data
        );
    }

    public function getEmpresaById(int $empresa_id)
    {
        return Empresa::withTrashed()->findOrFail($empresa_id);
    }

    public function getEmpresaByCnpj(string $cnpj)
    {
        return Empresa::query()->firstWhere('cnpj', 'like', $cnpj);
    }

    public function updateEmpresa(int $empresa_id, array $data)
    {
        return Empresa::find($empresa_id)->update($data);
    }

    public function search($search)
    {
        $empresa = Empresa::query()->limit(10);
        $numeric = only_numbers($search);
        $numeric_length = strlen($numeric);
        // may be cnpj
        if ($numeric && $numeric_length > 4) {
            return $empresa->where('cnpj', 'like', "%$search%")->get();
        }
        // may be id
        if ($numeric && $numeric_length > 1 && $numeric_length < 5) {
            return $empresa->where('id', '=', $search)->get();
        }
        // is string and less 5
        if (strlen($search) < 5) {
            return [];
        }
        return $empresa->where('razao_social', 'like', "%$search%")->get();
    }

    public function desativaEmpresa(int $id, array $data)
    {
        try {
            DB::beginTransaction();
            $empresa = Empresa::query()->find($id);
            $empresa->motivo_desativacao()->create([
                'motivo' => $data['motivo'],
                'descricao' => $data['descricao'] ?? null,
                'data_competencia' => $data['data_competencia'] ?? null,
                'usuario_id' => auth('api_usuarios')->id(),
                'data_encerramento' => $data['data_encerramento']
            ]);

            $empresa->update(['status_id' => array_search('Desativação Agendada', Empresa::$status)]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            abort(500, 'Erro ao desativar empresa. ' . $e->getMessage());
        }

        return true;
    }

    public function getEmpresasDesativacaoAgendada()
    {
        return Empresa::query()
            ->where('status_id', array_search('Desativação Agendada', Empresa::$status))
            ->get();
    }

    public function getEmpresasCongelamentoAgendado()
    {
        return Empresa::query()
            ->where('status_id', array_search('Congelamento Agendado', Empresa::$status))
            ->get();
    }
}
