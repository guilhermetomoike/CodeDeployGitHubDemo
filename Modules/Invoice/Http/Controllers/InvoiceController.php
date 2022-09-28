<?php

namespace Modules\Invoice\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Invoice\Contracts\Invoice\ICancelInvoiceService;
use Modules\Invoice\Http\Requests\CreateInvoiceRequest;
use Modules\Invoice\Repositories\InvoiceRepository;
use Modules\Invoice\Transformers\FaturaResource;
use Modules\Invoice\Jobs\FaturaToHonorarioJob;
use App\Models\AssinaturaPagamento;
use App\Models\Cliente;
use App\Models\ClientePlano;
use App\Models\Empresa;
use App\Models\EmpresaFuncionario;
use App\Models\Faturamento;
use App\Models\Payer\PayerContract;
use App\Services\Recebimento\Gatway\Asas\AsasService;
use App\Services\Recebimento\Gatway\Asas\Common\AsasFatura;
use App\Services\Recebimento\Gatway\Iugu\IuguService;
use AsyncAws\Core\Result;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\ContasReceber;
use Modules\Invoice\Entities\Fatura;
use Modules\Invoice\Http\Requests\CreateAntecipacaoClienteRequest;
use Modules\Invoice\Jobs\FaturaToHonorarioAsasJob;
use Modules\Invoice\Services\FaturaService;
use Modules\Invoice\Services\RelatorioInvoiceService;
use Modules\Plans\Entities\PlanSubscription;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InvoiceController
{

    private $faturaService;
    private $asasService;
    private $relatorioInvoiceService;
    public function __construct(FaturaService $faturaService, AsasService $asasService,RelatorioInvoiceService $relatorioInvoiceService)
    {
        $this->faturaService = $faturaService;
        $this->asasService = $asasService;
        $this->relatorioInvoiceService = $relatorioInvoiceService;
    }

    public function index(Request $request)
    {

        ini_set('max_execution_time', 180); //3 minutes
        ini_set("memory_limit", "10056M");
        $from = $request->get('from');
        $to = $request->get('to');
        $status = $request->get('status');
        $carteiras = $request->get('carteira');
        $tipo =   $request->get('tipoCobranca');

        $faturas = $this->faturaService->getFaturas($from, $to, $status, $tipo);

        $resumo = $this->faturaService->resumoFaturas($faturas);
        if (isset($carteiras)) {
            $faturas =  $this->filtroCarteiras($faturas, $carteiras);
        }

        return FaturaResource::collection($faturas)->additional(['resumo' => $resumo]);
    }

    public function filtroCarteiras($data, $carteiras)
    {
        $result = [];
        $printtrue = false;
        foreach ($data as $item) {

            foreach ($item->payer->carteirasrel as $carteira) {


                if (in_array($carteira->id, $carteiras)) {
                    $printtrue = true;
                }
                if ($printtrue) {
                    $result[] = $item;
                }
                $printtrue = false;
            }
        }
        return $result;
    }


    public function store(CreateInvoiceRequest $request)
    {
        $data = $request->validated();
        try {
            if ($data['payer_type'] == 'cliente') {
                $payer =   Cliente::where('id', $data['payer_id'])->first();
                if (!$payer->pay_cont_id) {
                    $this->asasService->criarCliente($payer);
                }
            }


            $fatura = $this->faturaService->create($data);
            (new AsasService())->criarFaturaWithItems($fatura);
            FaturaToHonorarioAsasJob::dispatch($fatura->fresh(), $data['tipo_cobrancas_id']);
        } catch (\Exception $e) {
            if ($fatura ?? false) $fatura->delete();
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return response()->json($fatura, Response::HTTP_CREATED);
    }

    public function storeAtrasadas(Request $request)
    {
        // return $request;
        try {
            // if ($data['payer_type'] == 'cliente') {
            //     $payer =   Cliente::where('id', $data['payer_id'])->first();
            //     if (!$payer->pay_cont_id) {
            //         $this->asasService->criarCliente($payer);
            //     }
            // }
            $faturas =   Fatura::query()->whereIn('id', $request->fatAtrasadas)->get();
            $somatotal = 0;
            foreach ($faturas as $fatura) {
                if (!$fatura->movimento) {
                    foreach ($fatura->items as $it) {
                        $items[] = ['valor' => $it->valor, 'descricao' => $it->descricao];
                    }
                } else {
                    foreach ($fatura->movimento as $mov) {
                        $items[] = ['valor' => $mov->valor, 'descricao' => $mov->descricao];
                    }
                }
                $somatotal += $fatura->subtotal;
                $this->cancelarFatura($fatura);
                $newsfat[] =    $this->faturaService->create([
                    'data_competencia' => $fatura->data_competencia,
                    'payer_type' => $fatura->payer_type,
                    'payer_id' => $fatura->payer_id,
                    'data_vencimento' => $request->data_vencimento,
                    'status' => 'pendente',
                    'subtotal' => $fatura->subtotal,
                    'forma_pagamento_id' => 1,
                    'items' => $items
                ]);
            }


            $objetoassas = $newsfat[count($faturas) - 1];
            $objetoassas->subtotal = $somatotal;
            // $objetoassas->save();

            // return $objetoassas;

            $fat =   (new AsasService())->criarFaturaAtrasadasWithItems($objetoassas);

            foreach ($newsfat as $newfat) {

                $newfat->gatway_fatura_id = $fat->id;
                $newfat->fatura_url = $fat->invoiceUrl;
                $newfat->fatura_url_boleto = $fat->bankSlipUrl;
                $newfat->save();
                // FaturaToHonorarioAsasJob::dispatch($newfat->fresh(), 1);

            }
        } catch (\Exception $e) {
            if ($fatura ?? false) $fatura->delete();
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return response()->json($fatura, Response::HTTP_CREATED);
    }


    public function show($id)
    {
        $fatura = $this->faturaService->getFatura($id);
        return new FaturaResource($fatura);
    }


    public function listaAdicionais($payer_id, $payer_type)
    {
        $data = Empresa::where('id', $payer_id)->with('faturamento', 'funcionarios', 'sociosAdicionais')->first();

        // return  response()->json($data, 200);
        $result = (object) [];
        if (count($data->sociosAdicionais) > 2) {
            $result->socios = ['descricao' => 'adicionais socios', 'valor' => count($data->sociosAdicionais) * 40];
        }
        if ($data->faturamento->faturamento < 120000) {
            $result->faturamento = ['descricao' => 'adicional pelo faturamento', 'valor' => 178];
        } else {
            $result->faturamento = ['descricao' => 'adicional pelo faturamento', 'valor' => 356];
        }

        if (count($data->funcionarios) > 0) {
            $result->funcionario = ['descricao' => 'adicional funcionarios', 'valor' => count($data->funcionarios) * 70];
        }


        return  response()->json($result, 200);
    }


    public function update(Request $request)
    {
        $data = $request->All();
        try {
            // $fatura = Fatura::where('id',$request->id)->first();
            $fatura = $this->faturaService->update((array) $data);

            // return response()->json($fatura->movimento[0]['id'] , Response::HTTP_BAD_REQUEST);
            (new AsasService())->updateFaturaWithItems($fatura);
            FaturaToHonorarioAsasJob::dispatch($fatura->fresh(), $data['tipo_cobrancas_id']);
        } catch (\Exception $e) {
            // if ($fatura ?? false) $fatura->delete();
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return response()->json($fatura, Response::HTTP_CREATED);
    }

    public function updateFaturaStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $fatura = $this->faturaService->updateFaturaStatus($request);

            DB::commit();

            return response()->json($fatura);
        } catch (Exception $e) {
            return response()->json($e, 200);
        }
    }
    public function salveMotivoCancelamento(Request $request)
    {
        $fatura =  Fatura::where('id', $request->id)->first();
        $fatura->motivo_cancelamento_id = $request->motivo_cancelamento_id;
        $fatura->save();
        return  $this->cancelarFatura($fatura);
    }

    public function cancelarFatura($fatura)
    {
        try {
            // $cancelInvoice->execute($id);

            $this->asasService->cancelarFatura($fatura);
        } catch (\Throwable $exception) {
            return response()->json(['message' => 'Erro na solicitação! [' . $exception->getMessage() . ']'], 400);
        }
        return response()->json(['message' => 'Operação realizada com sucesso!']);
    }

    public function estornarFatura(Request $request, $id)
    {
        $motivo = $request->get('motivo');
        $this->faturaService->estornarFatura($id, $motivo);
        return response()->json(['message' => 'Operação realizada com sucesso!']);
    }

    public function webhookFaturaLiberada(Request $request)
    {
        $subscription = AssinaturaPagamento::query()->where('gatway_id', $request->data['subscription_id'])->first();
        $payer = $subscription->payer;
        $payer->fatura()->create([
            'status' => $request->data['status'] === 'paid' ? 'pago' : 'pendente',
            'subtotal' => $request->data['amount'],
            'data_competencia' => competencia_anterior(),
            'gatway_fatura_id' => $request->data['id'],
            'data_recebimento' => $request->data['status'] === 'paid' ? today()->format('Y-m-d') : null
        ]);
    }

    public function getByPayer(Request $request, string $payer_type, int $payer_id, InvoiceRepository $invoiceRepository)
    {
        $status = $request->get('status');
        $invoices = $invoiceRepository->findByPayer($payer_type, $payer_id, $status);
        if (!$invoices) {
            return response()->json(
                ['message' => 'Nenhum registro encontrado.'],
                Response::HTTP_BAD_REQUEST
            );
        }
        return response()->json($invoices);
    }

    public  function getByPayerAtrasadas(string $payer_type, int $payer_id, InvoiceRepository $invoiceRepository)
    {

        $invoices = $invoiceRepository->findByPayerAtrasada($payer_type, $payer_id);
        if (!$invoices) {
            return response()->json(
                ['message' => 'Nenhum registro encontrado.'],
                Response::HTTP_BAD_REQUEST
            );
        }
        return response()->json($invoices);
    }

    public function destroy($invoice_id)
    {
        $deleted = $this->faturaService->destroy($invoice_id);
        if (!$deleted) {
            return new JsonResponse(['message' => 'Não foi possível realizar a operação!'], 400);
        }
        return new JsonResponse(['message' => 'Operação realizada com sucesso!']);
    }

    public function relatorioFaturas(Request $request)
    {
        // ini_set('max_execution_time', 180); //3 minutes
        // ini_set ("memory_limit", "10056M");
        $data = $this->index($request);
       return $this->relatorioInvoiceService->relatorioFaturas($data);
    }
    public function relatorioFaturasCliente(Request $request, InvoiceRepository $invoiceRepository)
    {
        $data = $request->All();
        $status =  $data('status');
        $invoices = $invoiceRepository->findByPayer( $data['payer_type'], $data['payer_id'], $status);
       return $this->relatorioInvoiceService->relatorioFaturas($invoices);
    }

    public function honorarioGuia(Request $request, AsasService $asasService)
    {
        $date = Carbon::now()->setDay(20)->format('Y-m-d');
        $date2 = Carbon::now()->setDay(15)->format('Y-m-d');

        // if ($request->gerar == 'arrumar') {
        //     $faturasAtradas = $asasService->listaFaturasAtrasadas();
        //     // return response()->json($faturasAtradas,200);
        //     foreach ($faturasAtradas->data as $fatura) {
        //         if ($fatura->dueDate == Carbon::now()->setDay(15)->format('Y-m-d')) {

        //             $f   =    Fatura::where('gatway_fatura_id', $fatura->id)->first();
        //             if(isset($f->id)){
        //             $contaReceber = ContasReceber::where('id', $f->conta_receber_id)->first();
        //             if (isset($contaReceber->id)) {

        //                 $faturaAsas = new AsasFatura;
        //                 $data_vencimento =  Carbon::parse($fatura->dueDate)->setDay(20)->format('Y-m-d');
        //                 // $data_final = Carbon::now()->format('Y-m-d');

        //                 $faturaAsas->setCustomer($fatura->customer);
        //                 $faturaAsas->setExternalReference($fatura->externalReference);
        //                 $faturaAsas->setDueDate($data_vencimento);


        //                 $totalValor = 0;
        //                 $texto = '';
        //                 foreach ($contaReceber->movimento as $mov) {
        //                     if ($texto == '') {
        //                         $texto = $mov->descricao;
        //                     } else {
        //                         $texto =  $texto . ', ' . $mov->descricao;
        //                     }
        //                     if ($mov->valor > 0) {
        //                         $totalValor = $mov->valor + $totalValor;
        //                     }
        //                 }
        //                 $faturaAsas->setValue($totalValor);
        //                 $faturaAsas->setBillingType('BOLETO');
        //                 $faturaAsas->setDescription($texto);
        //                 $faturaAsas->setDiscountFromMovimentoContasReceber($contaReceber->movimento);


        //                 $asasService->updateFatura($faturaAsas, $fatura->id);
        //             }
        //             }
        //         }
        //     }
        // }





        if ($request->gerar == 'sim') {
            $faturas =  Fatura::whereDate('data_vencimento', '<=', $date)
                ->whereDate('data_vencimento', '>=', $date2)
                ->get();
            foreach ($faturas as $fatura) {
                FaturaToHonorarioAsasJob::dispatch($fatura, 1);
            }
        }

        // if ($request->gerar == 'porvez') {
        //     $faturas =  Fatura::
        //         where('id', $request->fatura_id)
        //         ->get();
        //     foreach ($faturas as $fatura) {
        //         $fatura->updated_at = Carbon::now();
        //         $fatura->save();
        //         FaturaToHonorarioAsasJob::dispatch($fatura->fresh(), 1);
        //     }
        // }

        if ($request->gerar == 'porvez') {
            $faturas =  Fatura::where('id', $request->fatura_id)
                ->get();
            foreach ($faturas as $fatura) {
                FaturaToHonorarioAsasJob::dispatch($fatura, 1);
            }
        }



        // return 'deu bom';
    }
    public function getValueForStatus(Request $request)
    {

        if (isset($request->payer_id)) {

            if ($request->payer_type == 'empresa') {
                $plano = PlanSubscription::where('plan_subscriptions.payer_id', $request->payer_id)
                    ->join('plans', 'plans.id', 'plan_subscriptions.plan_id')->select('plans.price')->first();
            } else {

                $empresa_id = DB::table('clientes_empresas')->where('clientes_id', $request->payer_id)->select('empresas_id')->first();
                //    return response()->json($empresa_id,200);

                $plano = PlanSubscription::where('plan_subscriptions.payer_id', $empresa_id->empresas_id)
                    ->join('plans', 'plans.id', 'plan_subscriptions.plan_id')->select('plans.price')->first();
                // return $plano;
            }



            //    return  response()->json($plano,200) ;

            if (isset($plano->price)) {
                switch ($request->tipo) {
                    case 1:
                        return ['value' => $plano->price, 'tipo' => 'Honorario'];
                        break;

                    case 2:
                        return ['value' => 356 + (($plano->price / 30) * (int)$request->data_vencimento), 'tipo' => 'Congelamento'];
                        break;

                        // case 2:
                        //     return ['value' => $plano->price, 'tipo' => 'MULTA RESCISÓRIA CFE CONTRATO'];
                        //     break;

                    case 9:
                        if (Carbon::now() <= '2022-03-31') {
                            return ['value' => 250.00, 'tipo' => 'imposto de renda'];
                        } else {
                            return ['value' => 350.00, 'tipo' => 'imposto de renda'];
                            break;
                        }

                        // default:
                        // return ['value' => $plano->price, 'tipo' => 'Honorario'];

                        //     break;
                }
            }
            return 'plano nao existe ou esta deletado';
        }
        return 'plano nao existe ou esta deletado';
    }

    public function antecipacaoCliente(CreateAntecipacaoClienteRequest $request)
    {
        $data = $request->validated();
        try {
            if ($data['payer_type'] == 'cliente') {
                $payer =   Cliente::where('id', $data['payer_id'])->first();
                if (!$payer->pay_cont_id) {
                    $this->asasService->criarCliente($payer);
                }
            }

            $fatura =$this->faturaService->anticipacaoFatura($data);
            (new AsasService())->criarFaturaWithItems($fatura);
            FaturaToHonorarioAsasJob::dispatch($fatura->fresh(), $data['tipo_cobrancas_id']);
        } catch (\Exception $e) {
            if ($fatura ?? false) $fatura->delete();
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return response()->json($fatura, Response::HTTP_CREATED);
    }
}
