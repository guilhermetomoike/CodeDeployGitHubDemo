<?php


namespace App\Services\OrdemServico;


use App\Jobs\SendMailOSItemJob;
use App\Models\OrdemServico\OrdemServico;
use App\Models\OrdemServico\OrdemServicoAnexo;
use App\Repositories\OrdemServicoRepository;
use App\Services\FileService;
use App\Services\SlackService;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class OrdemServicoService
{
    private $ordemServicoRepository;

    /**
     * OrdemServicoService constructor.
     * @param OrdemServicoRepository $ordemServicoRepository
     */
    public function __construct(OrdemServicoRepository $ordemServicoRepository)
    {
        $this->ordemServicoRepository = $ordemServicoRepository;
    }

    public function storeAtividadeBase(array $data)
    {
        return $this->ordemServicoRepository->cadastraAtividadeBase($data);
    }

    public function getAtividadesBase()
    {
        return $this->ordemServicoRepository->getAtividadesBase();
    }

    public function cadastrarOrdemServicoBase(array $data)
    {
        return $this->ordemServicoRepository->cadastrarOrdemServicoBase($data);
    }

    public function getOsBase()
    {
        return $this->ordemServicoRepository->getOsBase();
    }

    public function getAll($data)
    {
        $params = (object)$data;
        return $this->ordemServicoRepository->getAll($params);
    }

    public function storeOrdemServico(array $data)
    {
        $ordemServico = $this->ordemServicoRepository->cadastrarOrdemServico($data);

        collect($data['anexos'] ?? [])->each(function (UploadedFile $anexo) use ($ordemServico) {
            $path = Storage::disk()->putFile(null, $anexo);
            $ordemServico->arquivos()->create([
                'nome_original' => $anexo->getClientOriginalName(),
                'caminho' => $path,
                'tags' => ['empresa_id' => $ordemServico->empresa_id]
            ]);
        });

        return $ordemServico;
    }

    public function getOsById(int $id)
    {
        return $this->ordemServicoRepository->getOsById($id);
    }

    public function iniciarAtividade(int $atividade_id)
    {
        return $this->ordemServicoRepository->iniciarAtividade($atividade_id);
    }

    public function finalizarAtividade(int $atividade_id)
    {
        return $this->ordemServicoRepository->finalizarAtividade($atividade_id);
    }

    public function storeAtividadeArquivo(array $input)
    {
        $atividade_id = array_shift($input);
        foreach ($input as $key => $value) {
            if ($value instanceof UploadedFile) {
                $atividade_os = $this->ordemServicoRepository->getAtividadeById($atividade_id);
                $data = [
                    'caminho' => $value->store(null),
                    'nome_original' => $value->getClientOriginalName(),
                    'tags' => ['empresa_id' => $atividade_os->ordem_servico->empresa_id]
                ];
                $arquivo = $atividade_os->arquivos()->create($data);
                return $arquivo;
            }
        }

        return false;
    }

    public function enviarEmailOsItem($os_item_id, array $emails, ?string $menssagem): bool
    {
        $os_item = $this->ordemServicoRepository->getOsItemById($os_item_id);
        try {
            SendMailOSItemJob::dispatchNow($os_item, $emails, $menssagem);
            $this->ordemServicoRepository->setEmailEnviado($os_item_id);
        } catch (\Throwable $e) {
//            if ($e instanceof QueryException) {
//                abort(400, "O Email foi enviado mas não foi possivel atualizar o relatório.");
//            }
            abort(400, "Falha no envio de email. {$e->getMessage()}");
        }
        return true;
    }

    public function estornarArquivoAtividade(array $data)
    {
        return $this->ordemServicoRepository->deleteArquivo($data['arquivo_id'], new FileService());
    }

    public function getListaOsByEmpresaId(int $empresa_id)
    {
        return $this->ordemServicoRepository->getOsListaByEmpresaId($empresa_id);
    }
}
