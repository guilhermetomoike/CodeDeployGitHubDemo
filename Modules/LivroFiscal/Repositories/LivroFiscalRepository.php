<?php


namespace Modules\LivroFiscal\Repositories;


use Illuminate\Support\Facades\DB;
use Modules\LivroFiscal\Entities\LivroFiscal;

class LivroFiscalRepository
{
    public function getAll(?string $status = null)
    {
        return LivroFiscal::with(['empresa' => function ($empresa) {
            $empresa
                ->select('empresas.id', 'razao_social', 'cnpj', 'created_at', 'inicio_atividades')
                ->with('carteiras:carteiras.id');
        }])
            ->when($status, function ($query, $value) {
                $query->where('status', $value);
            })
            ->with('arquivos')
            ->whereHas('empresa')
            ->get();
    }

    public function delete(int $id)
    {
        return LivroFiscal::destroy($id);
    }

    public function update(int $id, array $data)
    {
        $livroFiscal = LivroFiscal::find($id);

        try {
            DB::beginTransaction();
            foreach ($data['arquivos'] as $arquivo) {
                $livroFiscal->arquivos()->updateOrCreate([
                    'nome' => $arquivo['nome']
                ], $arquivo);
            }

            $livroFiscal->update([
                'status' => $data['status'],
                'observacao' => $data['observacao'],
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception('Erro ao salvar: ' . $exception->getMessage());
        }

        return $livroFiscal;
    }
}
