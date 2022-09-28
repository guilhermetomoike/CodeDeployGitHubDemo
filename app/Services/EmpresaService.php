<?php


namespace App\Services;


use App\Models\Empresa;
use App\Models\EmpresaPreCadastro;
use App\Repositories\EmpresaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmpresaService
{
    private EmpresaRepository $repository;
    /**
     * @var ArquivoService
     */
    private ArquivoService $arquivoService;

    public function __construct(ArquivoService $arquivoService)
    {
        $this->repository = new EmpresaRepository();
        $this->arquivoService = $arquivoService;
    }

    public function cadastrarAcessoNfse(int $empresa_id, array $data)
    {
        return $this->repository->updateAcessoNfse($empresa_id, $data);
    }

    public function cadastrarContaBancaria(int $empresa_id, array $data)
    {
        return $this->repository->updateContaBancaria($empresa_id, $data);
    }

    public function searchEmpresa($search)
    {
        if (strlen($search) < 2) {
            return [];
        }

        return $this->repository->search($search);
    }

    public function getEmpresa(int $id)
    {
        $empresa = $this->repository->getEmpresaById($id);

        $cliente_autenticado = auth('api_clientes')->user();

        if ($cliente_autenticado && !$cliente_autenticado->empresa->contains($empresa)) {
            abort(400, 'Você não está associado a esta empresa.');
        }

        return $empresa;
    }

    public function desativarEmpresa(int $id, array $data)
    {
        validator($data, [
            'motivo' => 'required',
            'data_competencia' => 'required|date_format:Y-m-d',
            'data_encerramento' => 'required|date_format:Y-m-d',
            'file' => 'nullable'
        ], ['motivo.required' => 'Informe o motivo do congelamento.'])->validate();

        if (isset($data['file'])) {
            $this->arquivoService->addClassFile($id, Empresa::class, $data['file'], 'Carta-de-trasferencia ');
        }

        return $this->repository->desativaEmpresa($id, $data);
    }

    public function getNotifiableEmail(int $id)
    {
        $empresa = $this->getEmpresa($id);
        $emails = $empresa->contatos()->email();
        return $emails;
    }

    public function setRequiredGuidesByEmpresa(Empresa $empresa, array $data)
    {
        return DB::transaction(function () use ($empresa, $data) {
            $empresa->required_guide()->detach();

            foreach ($data as $guide) {
                $empresa->required_guide()->attach($guide);
            }

            return $empresa;
        });
    }
}
