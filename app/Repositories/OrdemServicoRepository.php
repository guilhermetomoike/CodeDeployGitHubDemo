<?php

namespace App\Repositories;

use App\Models\OrdemServico\Arquivo;
use App\Models\OrdemServico\OrdemServico;
use App\Models\OrdemServico\OrdemServicoAtividade;
use App\Models\OrdemServico\OrdemServicoBase;
use App\Models\OrdemServico\OrdemServicoItem;
use App\Models\OrdemServico\OsAtividadeBase;
use App\Services\FileService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OrdemServicoRepository
{
    public function cadastrarOrdemServicoBase(array $data)
    {
        return DB::transaction(function () use ($data) {
            $osBase = OrdemServicoBase::query()->create($data);

            $osBase->atividades()->createMany($data['atividades']);

            return $osBase->with('atividades');
        });
    }

    public function getOsBase()
    {
        return OrdemServicoBase::with('atividades')->get()->toArray();
    }

    public function getAll($params)
    {
        $colunas = [
            'ordem_servico.id',
            'ordem_servico.cliente_id',
            'ordem_servico.empresa_id',
            'empresas.razao_social',
            'clientes.nome_completo',
            'ordem_servico.created_at',
            'ordem_servico.usuario_id'
        ];
        $query = OrdemServico::query()
            ->select($colunas)
            ->leftJoin('empresas', 'empresas.id', '=', 'ordem_servico.empresa_id')
            ->leftJoin('clientes', 'clientes.id', 'ordem_servico.cliente_id')
            ->leftJoin('os_atividade', 'os_atividade.ordem_servico_id', '=', 'ordem_servico.id')
            ->with(['items', 'usuario', 'atividades']);

        if ($params->search !== null || $params->search_data !== null) {
            $query = $this->buildFilterQuery($params, $query);
        }

        return $query
            ->groupBy($colunas)
            ->paginate($params->per_page);
    }

    /**
     * @param $params
     * @param $query
     * @return mixed
     */
    public function buildFilterQuery($params, $query)
    {
        if (strtolower($params->search) == 'pendente') {
            $query = $query->where("os_atividade.status", 'pendente');
        }

        if (strtolower($params->search) == 'concluido') {
            $query = $query->where("os_atividade.status", 'concluido');
        }

        if ($params->search_data !== null) {
            $query = $query
                ->where(DB::raw('DATE_FORMAT(ordem_servico.created_at, "%d/%m/%Y")'), $params->search_data);
        }

        return $query;
    }

    public function getOsListaByEmpresaId(int $empresa_id)
    {
        $colunas = [
            'ordem_servico.id',
            'ordem_servico.cliente_id',
            'ordem_servico.empresa_id',
            'empresas.razao_social',
            'clientes.nome_completo',
            'ordem_servico.created_at',
            'ordem_servico.usuario_id'
        ];
        $ordem_servico = OrdemServico::query()
            ->select($colunas)
            ->leftJoin('empresas', 'empresas.id', '=', 'ordem_servico.empresa_id')
            ->leftJoin('clientes', 'clientes.id', 'ordem_servico.cliente_id')
            ->leftJoin('os_atividade', 'os_atividade.ordem_servico_id', '=', 'ordem_servico.id')
            ->with(['usuario'])
            ->with(['atividades', 'items' => function (HasMany $items) {
                $items->with('arquivos');
            }])
            ->where('empresa_id', $empresa_id)
            ->groupBy($colunas)
            ->get();

        return $ordem_servico;

    }

    public function cadastrarOrdemServico(array $data)
    {
        return DB::transaction(function () use ($data) {

            $ordemServico = OrdemServico::query()->create($data);

            foreach ($data['os_base'] as $item) {
                $os_item = $ordemServico->items()->create($item);

                $atividades = $this->getAtividadesBaseForItem($os_item, $ordemServico->id);

                foreach ($atividades as $atividade) {

                    $atividade = $os_item->atividades()->create($atividade);

//                    foreach ($atividade['input'] as $input) {
//                        if (!$input) continue;
//                        $atividade->arquivos()->create((array)$input);
//                    }
                }
            }

            return $ordemServico;
        });

    }

    private function getAtividadesBaseForItem(OrdemServicoItem $os_item, $ordemServicoId)
    {
        $atividades = $os_item->atividades_base()->get();

        return $atividades->map(function (OsAtividadeBase $atividade) use ($ordemServicoId) {
            $atividade->setAttribute('ordem_servico_id', $ordemServicoId);
            $atividade->setAttribute('os_atividade_base_id', $atividade->id);
            return $atividade->only(['ordem_servico_id', 'os_atividade_base_id', 'input']);
        });
    }

    public function getOsById(int $id)
    {
        $ordemServico = OrdemServico::with(['anexos', 'items' => function (HasMany $item) {
            $item->with(['atividades' => function (HasMany $atividade) {
                $atividade->with(['arquivos']);
            }]);
        }])->select('ordem_servico.*', 'empresas.razao_social', 'clientes.nome_completo as socio', 'usuarios.nome_completo as responsavel')
            ->leftJoin('empresas', 'empresas.id', '=', 'empresa_id')
            ->leftJoin('clientes', 'clientes.id', '=', 'cliente_id')
            ->leftJoin('usuarios', 'usuarios.id', '=', 'usuario_id')
            ->find($id);

        return $ordemServico;
    }

    public function iniciarAtividade(int $atividade_id)
    {
        return OrdemServicoAtividade::query()
            ->find($atividade_id)
            ->update(['data_inicio' => now()]);
    }

    public function finalizarAtividade(int $atividade_id)
    {
        return OrdemServicoAtividade::query()
            ->find($atividade_id)
            ->update(['data_fim' => now(), 'status' => 'concluido']);
    }

    public function getAtividadeById(int $atividade_id)
    {
        return OrdemServicoAtividade::find($atividade_id);
    }

    public function storeAtividadeArquivo($id, string $path, $key, UploadedFile $file)
    {
        $os_arquivo = Arquivo::query()->where([
            'os_atividade_id' => $id,
            'nome' => $key
        ])->first();

        if ($os_arquivo) {
            return $os_arquivo->update([
                'nome' => $file->getClientOriginalName(),
                'path' => $path,
            ]);
        }

        return Arquivo::query()->create([
            'os_atividade_id' => $id,
            'path' => $path,
            'nome' => $file->getClientOriginalName(),
        ]);
    }

    public function getOsItemById(int $os_item_id)
    {
        return OrdemServicoItem::find($os_item_id);
    }

    public function setEmailEnviado(int $os_item_id)
    {
        return OrdemServicoItem::query()
            ->find($os_item_id)
            ->update(['email_enviado' => now()]);
    }

    public function deleteArquivo(int $arquivo_id, FileService $fileService)
    {
        $arquivo = Arquivo::query()->find($arquivo_id);

        $fileService->deleteFile($arquivo->path);

        return $arquivo->delete();
    }
}
