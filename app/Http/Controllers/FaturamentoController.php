<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFaturamentoRequest;
use App\Http\Resources\FaturamentoResource;
use App\Http\Resources\ImpostosFaturamentoResource;
use App\Mail\DeclaracaoMail;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Guia;
use App\Services\FaturamentoService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class FaturamentoController extends Controller
{
    /**
     * @var FaturamentoService
     */
    private $faturamentoService;

    /**
     * FaturamentoController constructor.
     * @param FaturamentoService $faturamentoService
     */
    public function __construct(FaturamentoService $faturamentoService)
    {
        $this->faturamentoService = $faturamentoService;
    }

    /**
     * Retorna os 12 ulimos faturamentos da empresa no parametro $request->empresa_id
     *
     * @param $empresa_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show($empresa_id)
    {
        $empresa = Empresa::findOrFail($empresa_id);

        $faturamentos = $this->faturamentoService->getFaturamento($empresa);

        return FaturamentoResource::collection($faturamentos);
    }

    /**
     * Retorna o valor de declaracao de renda da empresa no parametro $request->empresa_id
     *
     * @param GetFaturamentoRequest $request
     */
    public function showRenda(GetFaturamentoRequest $request)
    {
        try {
            $empresa = Empresa::findOrFail($request->get('empresa_id'));
            $renda = $this->faturamentoService->calculaRendaMedia($empresa);

            $response = [
                'data' => [
                    'renda_media' => formata_moeda($renda, true)
                ]
            ];

            return response()->json($response);
        } catch (\Exception $exception) {
            $code = $exception->getCode() ? $exception->getCode() : 500;
            return response()->json(['message' => $exception->getMessage()], $code);
        }
    }

    /**
     * Download do pdf de declaracao de faturamento
     *
     * @param GetFaturamentoRequest $request
     * @return Response
     */
    public function declaracaoFaturamentoPdf(GetFaturamentoRequest $request)
    {
        $empresa = Empresa::findOrFail($request->empresa_id);

        $faturamento = $this->faturamentoService->makePdfFaturamento($empresa);

        if ($request->sendEmail) {
            Mail::send(new DeclaracaoMail(
                'Faturamento',
                $request->email,
                $faturamento->output()
            ));

            return response(['message' => 'Enviado com sucesso.']);
        }

        return $faturamento->stream();
    }

    /**
     * Download do pdf de declaracao de renda
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function declaracaoRendaPdf(GetFaturamentoRequest $request)
    {
        $cliente_id = $request->cliente_id;

        if (!$cliente_id && is_a(auth('api_clientes')->user(), Cliente::class)) {
            $cliente_id = auth('api_clientes')->id();
        }

        $cliente = Cliente::find($cliente_id);

        $empresa = Empresa::findOrFail($request->empresa_id);

        $faturamento = $this->faturamentoService->makePdfRenda($empresa, $cliente);

        if ($request->sendEmail) {
            Mail::send(new DeclaracaoMail(
                'Renda',
                $request->email,
                $faturamento->output()
            ));

            return response(['message' => 'Enviado com sucesso.']);
        }

        return $faturamento->stream();
    }

    public function liquidoImpostos(int $id)
    {
        try {
            $resumo = $this->faturamentoService->makeImpostosResumeByEmpresaId($id);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        } catch (\Throwable $e) {
            return $this->errorResponse('Serviço indisponível no momento.', 500);
        }
        return new ImpostosFaturamentoResource($resumo);
    }
}
