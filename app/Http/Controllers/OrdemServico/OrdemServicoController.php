<?php

namespace App\Http\Controllers\OrdemServico;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnviarEmailAtividadeRequest;
use App\Http\Requests\OrdemServicoRequest;
use App\Http\Resources\OrdemServicoEmpresaListResource;
use App\Http\Resources\OrdemServicoResource;
use App\Services\OrdemServico\OrdemServicoService;
use Illuminate\Http\Request;

class OrdemServicoController extends Controller
{
    /**
     * @var OrdemServicoService
     */
    private $ordemServicoService;

    /**
     * OrdemServicoController constructor.
     * @param OrdemServicoService $ordemServicoService
     */
    public function __construct(OrdemServicoService $ordemServicoService)
    {
        $this->ordemServicoService = $ordemServicoService;
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $page = $request->get('page');
        $per_page = $request->get('per-page');
        $search_data = $request->get('search-data');
        $ordens_servico = $this->ordemServicoService->getAll(
            compact('search', 'page', 'per_page', 'search_data')
        );
        return OrdemServicoResource::collection($ordens_servico);
    }

    public function show($id)
    {
        $ordem_servico = $this->ordemServicoService->getOsById($id);
        return response($ordem_servico);
    }

    public function listByEmpresa($empresa_id)
    {
        $ordem_servico = $this->ordemServicoService->getListaOsByEmpresaId($empresa_id);
        return OrdemServicoEmpresaListResource::collection($ordem_servico);
    }

    public function store(OrdemServicoRequest $request)
    {
        $data = $request->all();
        $ordemServicoCreated = $this->ordemServicoService->storeOrdemServico($data);
        return $this->successResponse($ordemServicoCreated, 'Solicitação criada com sucesso.');
    }

    public function iniciarAtividade(Request $request)
    {
        $iniciada = $this->ordemServicoService->iniciarAtividade($request->atividade_id);
        if (!$iniciada) {
            return $this->badRequest(['message' => 'Não foi possível iniciar a atividade.']);
        }
        return response(['message' => 'Atividade iniciada com sucesso.']);
    }

    public function finalizarAtividade(Request $request)
    {
        $finalizada = $this->ordemServicoService->finalizarAtividade($request->atividade_id);
        if (!$finalizada) {
            return $this->badRequest(['message' => 'Não foi possível finaliar a atividade.']);
        }
        return response(['message' => 'Atividade finalizada com sucesso.']);
    }

    public function storeAtividadeArquivo(Request $request)
    {
        $arquivo = $this->ordemServicoService->storeAtividadeArquivo($request->all());
        if (!$arquivo) {
            return $this->errorResponse('nenhum campo foi atualizado.');
        }
        return $this->successResponse($arquivo, 'Campo salvo com sucesso', 201);
    }

    public function enviarEmail(EnviarEmailAtividadeRequest $request)
    {
        $os_item_id = $request->get('os_item_id');
        $emails = $request->get('emails');
        $mensagem = $request->get('mensagem');
        $email_enviado = $this->ordemServicoService->enviarEmailOsItem($os_item_id, $emails, $mensagem);
        if (!$email_enviado) {
            return $this->errorResponse('Falha no envio de email');
        }
        return $this->successResponse([], 'Email enviado com sucesso.');
    }

    public function estornarArquivo(Request $request)
    {
        $input_estornado = $this->ordemServicoService->estornarArquivoAtividade($request->all());
        if (!$input_estornado) {
            return $this->errorResponse();
        }
        return $this->successResponse(null, 'Estornado com sucesso');
    }
}
