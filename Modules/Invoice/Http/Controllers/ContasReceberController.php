<?php

namespace Modules\Invoice\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\EmpresaFuncionario;
use App\Models\Faturamento;
use App\Models\Payer\PayerContract;
use App\Models\Planos;
use App\Repositories\CrmRepository;
use App\Services\Recebimento\Gatway\Asas\AsasService;
use App\Services\Recebimento\Gatway\Asas\Common\AsasFatura;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Invoice\Entities\ContasReceber;
use Modules\Invoice\Entities\Fatura;
use Modules\Invoice\Entities\MovimentoContasReceber;
use Modules\Invoice\Jobs\CreateContasReceberJob;
use Modules\Invoice\Jobs\CreateFaturamentoJob;
use Modules\Invoice\Jobs\FaturaToHonorarioAsasJob;
use Modules\Invoice\Jobs\InvoiceGenerateCartaoJob;
use Modules\Invoice\Jobs\InvoiceGenerateJob;
use Modules\Invoice\Repositories\ContasReceberRepository;
use Modules\Invoice\Services\ContasReceber\CreateMovimentacaoService;
use Modules\Invoice\Transformers\ContasReceberDetailResource;
use Modules\Invoice\Transformers\ContasReceberResource;



use Modules\Invoice\Services\ContasReceber\CreateContasReceberVeryService;
use Modules\Invoice\Services\CreateEmpresafaturamentoService;
use Modules\Invoice\Services\CreateInvoiceCreditoServiceAsas;
use Modules\Invoice\Services\CreateInvoiceService;
use Modules\Invoice\Services\CreateInvoiceServiceAsas;
use Modules\Plans\Entities\Plan;
use Modules\Plans\Entities\PlanSubscription;
use Modules\Plans\Repositories\PlanSubscriptionRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpParser\Node\Stmt\Return_;

class ContasReceberController
{
    private ContasReceberRepository $contasReceberRepository;
    private CreateMovimentacaoService $movimentacaoService;

    public function __construct(
        ContasReceberRepository $contasReceberRepository,
        CreateMovimentacaoService $movimentacaoService
    ) {
        $this->contasReceberRepository = $contasReceberRepository;
        $this->movimentacaoService = $movimentacaoService;
    }

    public function index(Request $request)
    {
        $data = $this->contasReceberRepository->getContasReceber($request->all());
        return ContasReceberResource::collection($data);
    }

    public function show($id)
    {
        $data = $this->contasReceberRepository->getContasReceberById($id);
        return new ContasReceberDetailResource($data);
    }

    public function storeLancamento(Request $request)
    {
        $data = $this->movimentacaoService->createMoviment($request->all());
        return new JsonResponse($data);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public  function ClienteAsas(Request $request, AsasService $asasService, CreateInvoiceServiceAsas $createInvoiceServiceAsas)
    {


        //    return number_format(($calc = (28 * 0.11) + (((356/30)*28) * 0.01) + (356* 0.02) ),2);
        //    $payer=  Empresa::where('id',74)->first();
        // $faturasAtradas = $asasService->listaFaturasAtrasadas();
        // return response()->json($faturasAtradas,200);


        // try {
        //   DB::beginTransaction();

        $date = Carbon::now()->setDay(15)->format('Y-m-d');
        $date2 = Carbon::now()->setDay(1)->format('Y-m-d');

        $contaReceber = ContasReceber
            ::with(['payer'])
            // ->whereDate('vencimento', '<=', $date)
            // ->whereDate('vencimento', '>=', $date2)
            ->whereNull('consumed_at')
            ->where('payer_id', 74)
            ->first();


        return  $createInvoiceServiceAsas->execute($contaReceber);

        // $faturaAsas = new AsasFatura;

        // $texto = '';
        // foreach ($contaReceber->movimento as $mov) {
        //     if ($texto == '') {
        //         $texto = $mov->descricao ?? ' ';
        //     } else {
        //         $texto = ', ' . $mov->descricao ?? ' ';
        //     }
        // }
        // $fatura = Fatura::query()->where('id', $request->fatura_id)->first();

        // $data_inicial =  $fatura->data_vencimento;
        // $data_final = Carbon::now()->format('Y-m-d');

        // $diferenca = strtotime($data_final) - strtotime($data_inicial);
        // $dias = floor($diferenca / (60 * 60 * 24));
        // $calc = ($dias * 0.11) + (($dias / 30) * 0.01) + ($contaReceber->valor * 0.02) + $contaReceber->valor;

        // $faturaAsas->setDueDate('2021-11-30');
        // $faturaAsas->setValue($calc);
        // $faturaAsas->setBillingType('UNDEFINED');
        // $faturaAsas->setDescription($texto);
        // $faturaAsas->setDiscountFromMovimentoContasReceber($contaReceber->movimento);




        // } catch (\Exception $exception) {
        //     return 'Erro fatura: '  . json_encode([$exception->getMessage()]);
        //     Log::channel('stack')->info('Erro fatura: '. json_encode([$exception->getMessage()]));
        //     DB::rollBack();
        //     return;
        // }
    }

    public function criarBoletoTeste(Request $request, CreateInvoiceServiceAsas $createInvoiceServiceAsas, CreateInvoiceCreditoServiceAsas $createInvoiceCreditoServiceAsas, PlanSubscriptionRepository $subscriptionRepository, CrmRepository $crmRepository, ContasReceberRepository $contasReceberRepository)
    {



        if ($request->gerar == 'congG') {
            $empresasS = Empresa::where('status_id', 81)
                ->join('plan_subscriptions', 'plan_subscriptions.payer_id', 'empresas.id')
                ->leftjoin('plans', 'plans.id', 'plan_subscriptions.plan_id')
                // ->whereNull('plan_subscriptions.deleted_at')
                ->select('empresas.created_at', 'empresas.id', 'empresas.status_id', 'empresas.cnpj', 'empresas.razao_social', 'empresas.nome_empresa', 'plans.price as valor', 'plans.id as plans_id', 'plans.updated_at as plan_create')
                ->get()
                ->filter(
                    fn ($emps) =>
                    $emps->plans_id == 10 &&

                        isset($emps->ultfatura->data_vencimento) &&
                         Carbon::parse($emps->ultfatura->data_vencimento)->format('m') <= Carbon::now()->subMonths(6)->format('m') 
                );
            // $empresasA = Empresa::where('status_id', 81)
            //     ->join('plan_subscriptions', 'plan_subscriptions.payer_id', 'empresas.id')
            //     ->leftjoin('plans', 'plans.id', 'plan_subscriptions.plan_id')
            //     // ->whereNull('plan_subscriptions.deleted_at')
            //     ->select('empresas.created_at', 'empresas.id', 'empresas.status_id', 'empresas.cnpj', 'empresas.razao_social', 'empresas.nome_empresa', 'plans.price as valor', 'plans.id as plans_id', 'plans.updated_at as plan_create')
            //     ->get()
            //     ->filter(
            //         fn ($emps) =>

            //         $emps->plans_id == 11
            //     );
            if ($request->congG == 'ok') {
            foreach ($empresasS as $item) {
                $contasReceberRepository->createContasReceber([
                    'vencimento' => Carbon::now()->format('Y-m-20'),
                    'valor' => (float) $item->valor,
                    'descricao' => 'Cobrança Congelamento',
                    'payer_type' => $item->getModelAlias(),
                    'payer_id' => $item->id,
                ]);
            }
        }
            // foreach ($empresasA as $item) {
            //     $contasReceberRepository->createContasReceber([
            //         'vencimento' => Carbon::now()->format('Y-m-20'),
            //         'valor' => (float) $item->valor,
            //         'descricao' => 'Cobrança Congelamento',
            //         'payer_type' => $item->getModelAlias(),
            //         'payer_id' => $item->id,
            //     ]);
            // }
            return [ 'semestral' => $empresasS];
        }

        $date = Carbon::now()->setDay(21)->format('Y-m-d');
        $date2 = Carbon::now()->setDay(15)->format('Y-m-d');

        if ($request->gerar == 'gerarCong') {
            $contasReceber    = ContasReceber
                ::with(['payer'])
                ->whereDate('vencimento', '<=', $date)
                ->whereDate('vencimento', '>=', $date2)
                ->where('descricao', 'like', '%Cobrança Congelamento%')

                ->whereNull('consumed_at')
                ->join('plan_subscriptions', 'plan_subscriptions.payer_id', 'contas_receber.payer_id')
                ->leftjoin('plans', 'plans.id', 'plan_subscriptions.plan_id')
                ->select('contas_receber.*', 'plans.id as plans_id')
                ->get()
                ->filter(
                    fn ($contaReceber) =>
                    $contaReceber->payer  &&
                        $contaReceber->payer->congelada &&
                        $contaReceber->payer->status_id == 81

                );

            if ($request->ok == "gerarCong") {

                $contasReceber->each(fn (ContasReceber $contaReceber) => dispatch(
                    new InvoiceGenerateJob($contaReceber)
                ));
            } else {
                return response()->json($contasReceber, 200);
            }
        }

        // if ($request->gerar == 'arrumarHono') {

            
        //     $faturas = Fatura::where('created_at', '>', '2022-04-08 05:00')
        //     ->where('subtotal', 178)->where('tipo_cobrancas_id', 2)->get();

        //     if ($request->ok == 'arrumarHono') {
        //         foreach ($faturas as $fatura) {
        //             FaturaToHonorarioAsasJob::dispatch($fatura, 1);
        //         }
        //     } else {
        //         return response()->json($faturas,200);
        //     }
        // }

        if ($request->gerar == 'nao') {

            $data = [];
            $contasReceber    = ContasReceber
                ::with(['payer'])
                ->whereDate('vencimento', '<=', $date)
                ->whereDate('vencimento', '>=', $date2)
                ->whereNull('consumed_at')

                ->get()
                ->filter(
                    fn ($contaReceber) =>
                    $contaReceber->payer  &&

                        !$contaReceber->payer->congelada &&
                        $contaReceber->payer->status_id !== 81
                );

            // foreach ($contasReceber as $item) {

            //     // $data[$item->payer_id][] = $item;
            //     if ($item->vencimento == '2022-02-15') {
            //     //    ContasReceber::where('payer_id', $item->payer_id)->where('vencimento', '2022-03-15')->update(['vencimento'=>'2022-04-20']);
            //     //    ContasReceber::where('payer_id', $item->payer_id)->where('vencimento', '2022-04-20')->update(['vencimento'=>'2022-05-20']);
            //     //    ContasReceber::where('payer_id', $item->payer_id)->where('vencimento', '2022-03-20')->update(['vencimento'=>'2022-04-20']);
            //     //    ContasReceber::where('payer_id', $item->payer_id)->where('vencimento', '2022-02-20')->update(['vencimento'=>'2022-03-20']);

            //        $data[] = $item;
            //     }
            // }
            // return $data;

            // foreach ($contasReceber as $item) {
            //     ContasReceber::where('id',$item->id)->update(['valor'=>356]);

            //     foreach ($item->movimento as $mov) {
            //         if ($mov->descricao == "Lançamento de Honorário mensal") {

            //             DB::table('movimento_contas_receber')->where('id', $mov->id)
            //                 ->update(['valor' => 356]);
            //         }
            //     }
            // }

            return $contasReceber;
        }

        if ($request->gerar == 'cartao_credito') {


            $contasReceber    = ContasReceber
                ::with(['payer'])
                ->whereDate('vencimento', '<=', $date)
                ->whereDate('vencimento', '>=', $date2)
                ->whereNull('consumed_at')

                ->get()
                ->filter(
                    fn ($contaReceber) =>
                    $contaReceber->payer  &&
                        $contaReceber->valor > 0 &&
                        $contaReceber->payer->cartao_credito->count() &&
                        !$contaReceber->payer->congelada &&
                        $contaReceber->payer->status_id !== 81
                );



            return $contasReceber;
        }

    
        if ($request->gerar == 'porvez') {
            $contaReceber = ContasReceber
                ::with(['payer'])
                ->whereDate('vencimento', '<=', $date)
                ->whereDate('vencimento', '>=', $date2)
                ->whereNull('consumed_at')
                ->where('payer_id', $request->payer_id)
                ->first();

            return  $createInvoiceServiceAsas->execute($contaReceber);
        }
        if ($request->gerar == 'porvezcredito') {
            $contaReceber = ContasReceber
                ::with(['payer'])

                ->whereNull('consumed_at')
                ->where('id', $request->id)
                ->first();

            return  $createInvoiceCreditoServiceAsas->execute($contaReceber);
        }
    }

    public function createContasReceber(Request $request, CreateContasReceberVeryService $contasReceberService, PlanSubscriptionRepository $subscriptionRepository)
    {
        $subscription = Empresa::where('id', $request->get('id'))->first();
        return $subscription;
        // return   $contasReceberService->createContasReceberByPayer($subscription, false);
    }

    public function relatorioSociosAfetados()
    {
        $date = Carbon::now()->setDay(15)->format('Y-m-d');
        $date2 = Carbon::now()->setDay(1)->format('Y-m-d');

        $contasReceber = ContasReceber
            ::with(['payer'])
            ->whereDate('vencimento', '<=', $date)
            ->whereDate('vencimento', '>=', $date2)
            // ->whereNull('consumed_at')
            ->with('cliente', 'empresa')
            ->get();

        $data = [];


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Socios Adicionais.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Socios Adicionais');

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:D1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);



        $sheet->setCellValue('A3', 'ID')->setCellValue('B3', 'quantidade socios')->setCellValue('C3', 'Valor')
            ->setCellValue('D3', 'IDs socios');

        $sheet->getStyle("A3:D3")->getFont()->setBold(true);
        $i = 4;
        // return $contasReceber;

        foreach ($contasReceber as $contaReceber) {
            $addicionais_socios = null;
            $socios = '';
            $totalReceive = 0;
            if (isset($contaReceber->empresa[0]) and count($contaReceber->empresa) > 2) {

                foreach ($contaReceber->empresa as $socio) {

                    $socios =  $socios . ' ' . $socio['clientes_id'];
                }
                $addicionais_socios =  count($contaReceber->empresa);
                $totalReceive = $totalReceive + (($addicionais_socios - 2) * 40);
            } else {
                if (count($contaReceber->cliente) > 2) {
                    foreach ($contaReceber->cliente as $socio) {
                        $socios =  $socios . ' ' . $socio['clientes_id'];
                    }
                    $addicionais_socios =  count($contaReceber->cliente);
                    $totalReceive = $totalReceive + (($addicionais_socios - 2) * 40);
                }
            }
            if ($totalReceive > 0) {

                $contaReceber->addicionais_socios = $addicionais_socios;
                $contaReceber->valor = $totalReceive +  $contaReceber->valor;
                $contaReceber->socios = $socios;
                $data[] = (object) $contaReceber;
            }
        }

        // return $data;
        foreach ($data as $item) {



            $sheet->setCellValue('A' . $i, $item->payer_id . ' ' . $item->payer_type)->setCellValue('B' . $i, $item->addicionais_socios)
                ->setCellValue('C' . $i, $item->valor)->setCellValue('D' . $i, $item->socios);

            $i++;
        }



        $sheet->getPageSetup()->setPrintArea('A1:D' . intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }


    public function uploadFaturamentos(Request $request, CreateEmpresafaturamentoService $CreateEmpresafaturamentoService)
    {

        $spreadsheet = IOFactory::load($request->file);
        $number = $spreadsheet->getSheetCount();
        // return $number;
        $arquivo = [];
        for ($i = 0; $i < $number; $i++) {
            $spreadsheet->setActiveSheetIndex($i);
            $sheet = $spreadsheet->getActiveSheet();

            if ($sheet->getCell('Z12')->getValue() > 0) {
                $cnpj  = $sheet->getCell('W4')->getValue();

                $empresa  = Empresa::select('id')->where('cnpj', $cnpj)->first();

                if (isset($empresa->id)) {
                    $arquivo[$i][0]['faturamento'] = $sheet->getCell('Z11')->getValue();
                     $date =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($sheet->getCell('C8')->getValue());
                    $arquivo[$i][0]['mes'] =  Carbon::parse($date)->format('Y-m-01');
                    $arquivo[$i][0]['empresas_id'] = $empresa->id;
                }
        
                
            }
        }

        // return $arquivo;

        foreach ($arquivo as $mes) {

            foreach ($mes as $item) {

                $fac =   Faturamento::where('empresas_id', $item['empresas_id'])->where('mes', $item['mes'])->first();

                if (!isset($fac->id)) {
                    if ($item['faturamento'] > 0) {

                        CreateFaturamentoJob::dispatch($item);
                    }
                }
            }
        }


        // $faturamentos->each(fn(Faturamento $faturamento) => dispatch(
        //     new CreateFaturamentoJob($faturamento)

        // ));

        return response()->json('Faturamentos erguidos com sucesso', 200);
    }

    public function listar_faturamentos(){
      return     Faturamento::with('empresa')->orderBy('id','desc')->limit(1000)->get();
    }
    public function uploadFuncinarios(Request $request, CreateEmpresafaturamentoService $CreateEmpresafaturamentoService)
    {

        $spreadsheet = IOFactory::load($request->file);


        $arquivo = [];

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $linesCount = count($sheet->toArray());
        count($sheet->toArray());

        for ($i = 0; $i <=  $linesCount; $i++) {

            $cnpj =   $this->getCnpj((string)$sheet->getCell('f' . $i)->getValue());


            if (isset($cnpj[0])) {
                if (strlen($cnpj[0]) == 14) {
                    $empresa  = Empresa::select('id')->where('cnpj', $cnpj[0])->first();
                    if (isset($empresa->id)) {
                        $arquivo[$i]['empresa_id'] = $empresa->id;


                        for ($k = $i; $k <=  $linesCount; $k++) {

                            if (strlen($sheet->getCell('N' . $k)->getValue()) == 11) {
                                $arquivo[$i]['funcioarios'][$k]['empresa_id'] =  $arquivo[$i]['empresa_id'];
                                $arquivo[$i]['funcioarios'][$k]['cpf'] = $sheet->getCell('N' . $k)->getValue();
                                $arquivo[$i]['funcioarios'][$k]['salario'] = $sheet->getCell('AL' . $k)->getValue();
                                $arquivo[$i]['funcioarios'][$k]['nome'] = $sheet->getCell('D' . $k)->getValue();
                            }

                            if (str_replace(" ", "", $sheet->getCell('D' . $k)->getValue()) ==    "Totaldeempregados:") {
                                $k = $linesCount;
                            }
                        }
                    }
                }
            }
            $cnpj = [];
        }



        // return $arquivo;


        $fun2 = [];
        foreach ($arquivo as $item) {

            foreach ($item['funcioarios'] as $fun) {

                $funcionario =   EmpresaFuncionario::where('cpf', $fun['cpf'])->first();
                if (!isset($funcionario->id)) {
                    $fun2[] = $fun;
                    // $fun2[]=    EmpresaFuncionario::create($fun)->id;   
                }
            }
        }
        return   response()->json($fun2, 200);
    }
    public function getCnpj(string $text)
    {

        preg_match_all('/\b\d{2,3}\.\d{3}\.\d{3}\/\d{4}\-\d{2}\b|\b\d{2,3}\.\d{3}\. \d{3}\/\d{4}\-\d{2}\b/m', $text, $matches);
        return collect($matches)
            ->flatten()
            ->unique()
            ->map(function ($cnpj) {
                return formata_cnpj_bd(str_replace(" ", "", $cnpj));
            });
    }


    public function storeLancamentoAdicionais()
    {


        $data['adicionalFaturamento']   = Empresa::with('faturamentoAdicionais', 'contas_receber')->select('id', 'nome_empresa', 'cnpj')->get()->filter(
            fn ($empresa) =>
            !$empresa->congelada &&
                $empresa->status_id !== 81
                && isset($empresa->contrato->extra['clicksign'])
                && isset($empresa->contrato->arquivos[0]->id)
        );



        $data['adicionalSocios']  = Empresa::with('sociosAdicionais', 'contas_receber')->select('id', 'nome_empresa', 'cnpj')->get()->filter(
            fn ($empresa) =>
            !$empresa->congelada &&
                $empresa->status_id !== 81 &&
                count($empresa->sociosAdicionais) > 2
                && isset($empresa->contrato->extra['clicksign'])
                && isset($empresa->contrato->arquivos[0]->id)


        );

        $data['adicionalFuncionarios'] = Empresa::with('funcionarios', 'contas_receber')->select('id', 'nome_empresa', 'cnpj')->get()->filter(
            fn ($empresa) =>
            !$empresa->congelada &&
                $empresa->status_id !== 81 &&
                count($empresa->funcionarios) > 0 &&
                $empresa->id !== 200
                && isset($empresa->contrato->extra['clicksign'])
                && isset($empresa->contrato->arquivos[0]->id)
        );


        foreach ($data['adicionalFaturamento'] as $fat) {


            if (isset($fat->faturamentoAdicionais->faturamento)) {
                if (isset($fat->contas_receber->id)) {
                    $contador = 0;
                    $fatur = $fat->faturamentoAdicionais->faturamento;
                    while ($fatur >= 40000) {
                        $fatur =  $fatur - 40000;
                        $contador++;
                    }
                    if ($contador > 0) {


                        $this->movimentacaoService->createMovimentAddicionais(['contaReceberId' => $fat->contas_receber->id, 'valor' => 178 * $contador, 'descricao' => 'Adicional Faturamento']);
                    }
                }
            }
        }

        foreach ($data['adicionalSocios'] as $socio) {

            if (count($socio->sociosadicionais) > 0) {
                if (isset($socio->contas_receber->id)) {
                    $this->movimentacaoService->createMovimentAddicionais(['contaReceberId' => $socio->contas_receber->id, 'valor' => (count($socio->sociosadicionais) - 2) * 40, 'descricao' => 'Adicional Socios']);
                }
            }
        }

        foreach ($data['adicionalFuncionarios'] as $fun) {


            if (isset($fun->funcionarios[0]->id)) {
                if (isset($fun->contas_receber->id)) {


                    $this->movimentacaoService->createMovimentAddicionais($a[] = ['contaReceberId' => $fun->contas_receber->id, 'valor' => count($fun->funcionarios) * 70, 'descricao' => 'Adicional Funcionarios']);
                }
            }
        }
        return 'sucesso';
    }

    public function relatorioLancamentoAdicionais()
    {


        $data['adicionalFaturamento']   = Empresa::with('faturamentoAdicionais', 'contas_receber')->select('id', 'nome_empresa', 'cnpj')->get()->filter(
            fn ($empresa) =>
            !$empresa->congelada &&
                $empresa->status_id !== 81
                && isset($empresa->contrato->extra['clicksign'])
                && isset($empresa->contrato->arquivos[0]->id)


        );




        $data['adicionalSocios']  = Empresa::with('sociosAdicionais', 'contas_receber')->select('id', 'nome_empresa', 'cnpj')->get()->filter(
            fn ($empresa) =>
            !$empresa->congelada &&
                $empresa->status_id !== 81 &&
                count($empresa->sociosAdicionais) > 2
                && isset($empresa->contrato->extra['clicksign'])
                && isset($empresa->contrato->arquivos[0]->id)


        );



        $data['adicionalFuncionarios'] = Empresa::with('funcionarios', 'contas_receber')->select('id', 'nome_empresa', 'cnpj')->get()->filter(
            fn ($empresa) =>
            !$empresa->congelada &&
                $empresa->status_id !== 81 &&
                count($empresa->funcionarios) > 0 &&
                $empresa->id !== 200
                && isset($empresa->contrato->extra['clicksign'])
                && isset($empresa->contrato->arquivos[0]->id)



        );

        foreach ($data['adicionalFaturamento'] as $fat) {



            if (isset($fat->faturamentoAdicionais->faturamento)) {

                if (isset($fat->contas_receber->id)) {
                    $contador = 0;
                    $fatur = $fat->faturamentoAdicionais->faturamento;

                    // if ($fat->faturamentoAdicionais->faturamento >= 40000 && $fat->faturamentoAdicionais->faturamento <= 80000) {


                    //     $relatorio[0][] =      ['empresa_id' => $fat->id, 'empresa' => $fat->nome_empresa, 'cnpj' => $fat->cnpj, 'contaReceberId' => $fat->contas_receber->id, 'valor' => 178, 'descricao' => 'Adicional Faturamento'];
                    // }
                    // if ($fat->faturamento_adicionais->faturamento > 80000) {
                    //     $relatorio[0][] =      ['empresa_id' => $fat->id, 'empresa' => $fat->nome_empresa, 'cnpj' => $fat->cnpj, 'contaReceberId' => $fat->contas_receber->id, 'valor' => 356, 'descricao' => 'Adicional Faturamento'];
                    // }
                    while ($fatur >= 40000) {
                        $fatur =  $fatur - 40000;
                        $contador++;
                    }

                    if ($contador > 0) {

                        $relatorio[0][] =      ['empresa_id' => $fat->id, 'empresa' => $fat->nome_empresa, 'cnpj' => $fat->cnpj, 'contaReceberId' => $fat->contas_receber->id, 'valor' => 178 * $contador, 'descricao' => 'Adicional Faturamento'];
                    }
                }
            }
        }



        foreach ($data['adicionalSocios'] as $socio) {

            if (count($socio->sociosadicionais) > 0) {
                if (isset($socio->contas_receber->id)) {
                    $relatorio[1][] =  ['empresa_id' => $socio->id, 'empresa' => $socio->nome_empresa, 'cnpj' => $socio->cnpj, 'contaReceberId' => $socio->contas_receber->id, 'valor' => (count($socio->sociosadicionais) - 2) * 40, 'descricao' => 'Adicional Socios'];
                }
            }
        }

        foreach ($data['adicionalFuncionarios'] as $fun) {


            if (isset($fun->funcionarios[0]->id)) {
                if (isset($fun->contas_receber->id)) {


                    $relatorio[2][] =   ['empresa_id' => $fun->id, 'empresa' => $fun->nome_empresa, 'cnpj' => $fun->cnpj, 'contaReceberId' => $fun->contas_receber->id, 'valor' => count($fun->funcionarios) * 70, 'descricao' => 'Adicional Funcionarios'];
                }
            }
        }
        // return $relatorio;
        $spreadsheet = new Spreadsheet();

        for ($j = 0; $j < 3; $j++) {



            $spreadsheet->setActiveSheetIndex($j);
            $sheet = $spreadsheet->getActiveSheet();
            $filename = 'Relatorio  Adicionais.xlsx';
            switch ($j) {
                case 0:
                    $sheet->setTitle('Faturamentos');
                    $sheet->setCellValue('A1', 'Relatorio Faturamentos Adicionais');

                    break;
                case 1:
                    $sheet->setTitle('Socios');
                    $sheet->setCellValue('A1', 'Relatorio Socios Adicionais');

                    break;
                case 2:
                    $sheet->setTitle('Funcrionarios');
                    $sheet->setCellValue('A1', 'Relatorio Funcrionarios Adicionais');
                    break;
            }



            $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("A1:D1")->getFont()->setSize(18);
            $sheet->mergeCells('A1:D1');

            $sheet->getColumnDimension('A')->setWidth(8);
            $sheet->getColumnDimension('B')->setWidth(60);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(14);




            $sheet->setCellValue('A3', 'ID')->setCellValue('B3', 'empresa')->setCellValue('C3', 'cnpj')
                ->setCellValue('D3', 'Tipo Adicional')->setCellValue('E3', 'Valor');


            $sheet->getStyle("A3:E3")->getFont()->setBold(true);
            $i = 4;


            if (isset($relatorio[$j])) {
                foreach ($relatorio[$j] as $item) {

                    if ($item['empresa'] == null) {
                        $pre =   Empresa::with('precadastro')->where('id', $item['empresa_id'])->first();
                        $item['empresa'] = $pre->precadastro->empresa['razao_social'][0] ?? null;

                        $item['empresa'] =  $item['empresa'] == null ? $pre->razao_social : $pre->precadastro->empresa['razao_social'][0] ?? null;
                        // return $item;
                    }

                    // 

                    $sheet->setCellValue('A' . $i, $item['empresa_id'])->setCellValue('B' . $i, $item['empresa'])->setCellValue('C' . $i, $this->formata_cpf_cnpj($item['cnpj']))
                        ->setCellValue('D' . $i, $item['descricao'])->setCellValue('E' . $i, formata_moeda($item['valor'], true));

                    $sheet->getStyle("A" . intval($i))->getAlignment()->setHorizontal('center');
                    $sheet->getStyle("C" . intval($i) . ":E" . intval($i))->getAlignment()->setHorizontal('center');


                    $i++;
                }
            }



            $sheet->getPageSetup()->setPrintArea('A1:E' . intval($i));
            $spreadsheet->createSheet();
        }

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return response()->download(public_path($filename));
    }

    function formata_cpf_cnpj($cpf_cnpj)
    {
        /*
            Pega qualquer CPF e CNPJ e formata
    
            CPF: 000.000.000-00
            CNPJ: 00.000.000/0000-00
        */

        ## Retirando tudo que não for número.
        $cpf_cnpj = preg_replace("/[^0-9]/", "", $cpf_cnpj);



        $bloco_1 = substr($cpf_cnpj, 0, 2);
        $bloco_2 = substr($cpf_cnpj, 2, 3);
        $bloco_3 = substr($cpf_cnpj, 5, 3);
        $bloco_4 = substr($cpf_cnpj, 8, 4);
        $digito_verificador = substr($cpf_cnpj, -2);
        $cpf_cnpj_formatado = $bloco_1 . "." . $bloco_2 . "." . $bloco_3 . "/" . $bloco_4 . "-" . $digito_verificador;


        return $cpf_cnpj_formatado;
    }

    public function CreateContasReceberPosCadastro(Request $request)
    {
        // return 'Salvo com sucesso para gerar '.Carbon::parse($request->data)->format('d/m/Y');
        // return $request;

        $cr =   ContasReceber::query()->where('payer_id', $request->payer_id)->where('payer_type', 'empresa')->first();
        // return Carbon::parse($request->data)->format('Y-m-20');
        // return response()->json($cr,200);
        if (isset($cr->id)) {
            $cr->vencimento = Carbon::parse($request->data)->format('Y-m-20');
            $cr->save();
            return 'Salvo com sucesso para gerar ' . Carbon::parse($request->data)->format('20/m/Y');
        } else {

            $subscription =  PlanSubscription::query()
                // ->with(['payer'])
                ->where('payer_type', 'empresa')
                ->where('payer_id', $request->payer_id)
                ->with(['payer'])->first();

            $valor = $subscription->payer->plans()->sum('price');
            $this->contasReceberRepository->createContasReceber([
                'vencimento' => Carbon::parse($request->data)->format('Y-m-d'),
                'valor' => (float)$valor,
                'descricao' => 'Honorário mensal',
                'payer_type' => $subscription->payer->getModelAlias(),
                'payer_id' => $subscription->payer->id,
            ]);

            return 'Salvo com sucesso para gerar ' . Carbon::parse($request->data)->format('20/m/Y');
        }
    }

   

}
