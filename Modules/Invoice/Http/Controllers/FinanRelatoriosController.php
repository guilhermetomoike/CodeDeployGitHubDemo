<?php

namespace Modules\Invoice\Http\Controllers;

use App\Models\CartaoCredito;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Empresa\Alvara;
use App\Models\EmpresaMotivoCongelamento;
use App\Models\EmpresaPreCadastro;
use App\Repositories\CrmRepository;
use AsyncAws\Core\Result;
use Carbon\Carbon;
use Exception;
use Facade\FlareClient\Http\Client;
use Hamcrest\Core\HasToString;
use Illuminate\Http\Request;
use Modules\Invoice\Entities\Fatura;
use Modules\Plans\Entities\PlanSubscription;
use Modules\Plans\Repositories\PlanSubscriptionRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Entities\TipoCobranca;
use Modules\Invoice\Services\RelatorioFechamentoMensalService;

class FinanRelatoriosController
{
    private RelatorioFechamentoMensalService $relatorioFechamentoMensalService;

    public function __construct(RelatorioFechamentoMensalService $relatorioFechamentoMensalService)
    {
        $this->relatorioFechamentoMensalService = $relatorioFechamentoMensalService;
    }
    public  array $status = [
        1 => 'Processando',
        2 => 'Aguardando assinatura',
        3 => 'Aguardando certificado',
        4 => 'Aguardando CNPJ',
        5 => 'Aguardando alvará',
        6 => 'Aguardando acesso',
        7 => 'Aguardando simples',
        8 => 'Aguardando Documentação',
        9 => 'Pré-cadastro',
        70 => 'Desativação Agendada',
        71 => 'Desativada',
        80 => 'Congelamento Agendado',
        81 => 'Congelada',
        99 => 'Aguardando ativação',
        100 => 'Ativa',
    ];


    public function ConsultaEmpresaSemAlvara()
    {
        return Empresa
            ::with('alvara', 'carteirasrel')
            ->whereIn('status_id', [100, 99])
            ->whereDoesntHave('alvara')
            ->get();
    }

    public function consultaSemCrm($crmRepository)
    {
        $subscriptions = Empresa::query()->wherein('status_id', [100, 99])->with('carteirasrel')->get();


        $data = [];
        foreach ($subscriptions as $subscription) {

            $crm = $crmRepository->getCrmAppropriatedForBillingByEmpresa($subscription);
            if (!isset($crm->data_emissao)) {
                $data[] = $subscription;
            }
        }


        return $data;
    }

    public function consultaSemCrmPJ($crmRepository)
    {
        $subscriptions = Empresa::query()->wherein('status_id', [100, 99])->with('carteirasrel')->get();
        $data = [];
        foreach ($subscriptions as $subscription) {

            $crm = $crmRepository->getCrmAppropriatedByEmpresa($subscription);
            if (!isset($crm->data_emissao)) {
                $data[] = $subscription;
            }
        }
        return $data;
    }
    public function consultaComCrmPJ($crmRepository)
    {
        $subscriptions = Empresa::query()->wherein('status_id', [100, 99])->with('carteirasrel')->get();
        $data = [];
        foreach ($subscriptions as $subscription) {

            $crm = $crmRepository->getCrmAppropriatedByEmpresa($subscription);
            if (isset($crm->data_emissao)) {
                $data[] = $subscription;
            }
        }
        return $data;
    }




    public function consultaClienteXFatura()
    {
        return    Empresa::query()
            ->with('carteirasrel', 'fatura')
            ->select('empresas.id', 'empresas.cnpj', 'empresas.nome_empresa', 'empresas.razao_social', 'empresas.status_id')
            // ->whereIn('empresas.status_id', [100, 99, 70])
            ->get();
    }


    public function consultaPagantesCartao()
    {
        return    Empresa::query()
            ->with('carteirasrel')
            ->with(['fatura' => function ($fatura) {
                $fatura->where('forma_pagamento_id', 2);
                $fatura->where('data_vencimento', '>', Carbon::now()->format('Y-m-01'));
            }])
            ->whereHas('fatura', function ($fatura) {
                $fatura->where('forma_pagamento_id', 2);
                $fatura->where('data_vencimento', '>', Carbon::now()->format('Y-m-01'));
            })
            ->select('empresas.id', 'empresas.cnpj', 'empresas.nome_empresa', 'empresas.razao_social', 'empresas.status_id')
            // ->where('empresas.forma_pagamento_id', 2)
            // ->where('empresas.data_vencimento', Carbon::now()->format('Y-m-01'))
            ->get();
    }

    public function consultaCongeladosPlanosAnual()
    {
        return   Empresa::query()->with(['faturaAnualCong' => function ($fatura) {
            $fatura->join('fatura_item', 'fatura_item.fatura_id', 'fatura.id')->where('fatura_item.descricao', 'like', '%ANUAL%');
        }])
            ->whereHas('faturaAnualCong', function ($fatura) {
                $fatura->join('fatura_item', 'fatura_item.fatura_id', 'fatura.id')->where('fatura_item.descricao', 'like', '%ANUAL%');
            })
            ->get();
    }


    public function consultaCancelados($data_inicial, $data_final)
    {
        $result =    Empresa::query()->withTrashed()->with('carteirasrel', 'motivo_desativacao', 'precadastro', 'plans')
            // ->join('empresas', 'empresas.id', 'empresas_usuarios_cong.empresas_id')
            ->join('clientes_empresas', 'clientes_empresas.empresas_id', 'empresas.id')
            ->join('clientes', 'clientes.id', 'clientes_empresas.clientes_id')
            ->where('clientes_empresas.socio_administrador', 1)
            ->with(['motivo_desativacao' => function ($fatura) use ($data_inicial, $data_final) {

                $fatura->where('data_encerramento', '>=', Carbon::parse($data_inicial)->format('Y-m-d'));
                $fatura->where('data_encerramento', '<=', Carbon::parse($data_final)->format('Y-m-d'));
            }])
            ->whereHas('motivo_desativacao', function ($fatura) use ($data_inicial, $data_final) {
                $fatura->where('data_encerramento', '>=', Carbon::parse($data_inicial)->format('Y-m-d'));
                $fatura->where('data_encerramento', '<=', Carbon::parse($data_final)->format('Y-m-d'));
            })
            // ->where('empresas.congelada', 1)
            ->where('status_id', 71)
            ->select('empresas.*', 'empresas.id as empresas_id', 'clientes.id as clientes_id', 'clientes.nome_completo as nome_cliente')
            ->get();
        $data = [];
        foreach ($result as $item) {
            $data[$item->empresas_id] = $item;
        }
        return $data;
    }

    public function consultaCogelados()
    {
        $result = EmpresaMotivoCongelamento::query()
            ->join('empresas', 'empresas.id', 'empresas_usuarios_cong.empresas_id')
            ->join('clientes_empresas', 'clientes_empresas.empresas_id', 'empresas_usuarios_cong.empresas_id')
            ->join('clientes', 'clientes.id', 'clientes_empresas.clientes_id')
            ->where('clientes_empresas.socio_administrador', 1)
            ->where('empresas.congelada', 1)
            ->where('empresas.status_id', 81)
            ->select('empresas.razao_social', 'empresas.status_id', 'empresas.cnpj', 'empresas_usuarios_cong.empresas_id', 'empresas.nome_empresa', 'clientes.id', 'clientes.nome_completo as nome_cliente', 'data_congelamento')->get();
        $data = [];
        foreach ($result as $item) {
            $data[$item->empresas_id] = $item;
        }
        return $data;
    }

    public function consultaEmpresasPlanosDeleted()
    {
        $result = Empresa::query()
            ->leftjoin('plan_subscriptions', 'plan_subscriptions.payer_id', 'empresas.id')
            ->leftjoin('plans', 'plans.id', 'plan_subscriptions.plan_id')

            ->where('plan_subscriptions.deleted_at', '<>', null)
            ->select('empresas.id', 'empresas.razao_social', 'empresas.nome_empresa', 'plans.price')->get();
        // $data = [];
        // foreach ($result as $item) {
        //     $data[$item->empresas_id] = $item;
        // }
        return $result;
    }

    public function consultaEmpresasResidentes()
    {
        $result = Empresa::whereHas('residencia_medica')

            ->select('empresas.id', 'empresas.cnpj', 'empresas.razao_social', 'empresas.nome_empresa')->get();
        // $data = [];
        // foreach ($result as $item) {
        //     $data[$item->empresas_id] = $item;
        // }
        return $result;
    }


    public function consultaSemContratos()
    {
        return   Empresa::with('carteirasrel')
            ->with(['contrato' => fn ($query) => $query->with('arquivos')])->select('id', 'cnpj', 'nome_empresa', 'razao_social')->get()->filter(
                fn ($empresa) =>
                !$empresa->congelada &&
                    $empresa->status_id !== 81
                    && !isset($empresa->contrato->extra['clicksign'])
                    && !isset($empresa->contrato->arquivos[0]->id)



            );
    }


    public function relatorioCongeladas(Request $request)
    {
        // ini_set('max_execution_time', 180); //3 minutes
        // ini_set ("memory_limit", "10056M");
        $data = $this->consultaCogelados();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Congeladas Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Congeladas');

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:D1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(30);

        $sheet->setCellValue('A3', 'ID Empresa')->setCellValue('B3', 'Cnpj')->setCellValue('C3', 'Empresa')->setCellValue('D3', 'Cliente')->setCellValue('E3', 'Data Congelamento')->setCellValue('F3', 'Valor');

        $sheet->getStyle("A3:H3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        foreach ($data as $item) {
            $valor = 0;
            $faturas =   Fatura::where('payer_id', $item->empresas_id)
                ->orderBy('fatura.id', 'desc')
                ->where('status', 'pago')->where('payer_type', 'empresa')
                ->first();


            if (isset($faturas->data_competencia)) {
                if (Carbon::parse($faturas->data_competencia)->addMonths(6)->format('Y-m-d') < Carbon::now()->format('Y-m-1')) {
                    $valor = 178;
                } else if (Carbon::parse($faturas->data_competencia)->addMonths(12)->format('Y-m-d') < Carbon::now()->format('Y-m-1')) {
                    $valor = 356;
                } else if (Carbon::parse($faturas->data_competencia)->addMonths(18)->format('Y-m-d') < Carbon::now()->format('Y-m-1')) {
                    $valor = 534;
                }
            }
            // $valor = $valor - (178 * count($faturas));y


            $sheet->setCellValue('A' . $i, $item->empresas_id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, ($item->nome_empresa == null ? $item->razao_social : $item->nome_empresa))
                ->setCellValue('D' . $i, $item->clientes_id . ' ' . $item->nome_cliente)
                ->setCellValue('E' . $i, $item->data_congelamento)->setCellValue('F' . $i, $valor == 0 ? 'tudo em dia' : $valor);
            $i++;
        }
        $sheet->getPageSetup()->setPrintArea('A1:D' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename), $filename);
    }

    public function relatorioCanceladas(Request $request)
    {
        // ini_set('max_execution_time', 180); //3 minutes
        // ini_set ("memory_limit", "10056M");



        $params = $request->all();


        $data = $this->consultaCancelados($params['data_inicial'], $params['data_final']);


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Baixados Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Baixados');

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:J1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(32);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(22);
        $sheet->getColumnDimension('I')->setWidth(22);



        $sheet->setCellValue('C3', 'QUADRO RESUMO');
        $sheet->mergeCells('C3:D3');

        $sheet->setCellValue('C4', 'BAIXA DE EMPRESA')
            ->setCellValue('C5', 'ENCERRAMENTO')
            ->setCellValue('C6', 'SUBSTITUIÇÃO DE EMPRESA')
            ->setCellValue('C7', 'TRANSFERENCIA PARA OUTRO CONTADOR');


        $sheet->getStyle("C4:C7")->getFont()->setBold(true);

        $sheet->setCellValue('C9', 'TRANSFERENCIA PARA OUTRO CONTADOR')
            ->setCellValue('D9', 'ENCERRAMENTO')
            ->setCellValue('E9', 'SUBSTITUIÇÃO DE EMPRESA')
            ->setCellValue('F9', 'BAIXA DE EMPRESA');

        $sheet->getStyle("C9:F9")->getFont()->setBold(true);


        $sheet->setCellValue('B10', 'carteira 01')
            ->setCellValue('B11', 'carteira 02')
            ->setCellValue('B12', 'carteira 03')
            ->setCellValue('B13', 'carteira 04')
            ->setCellValue('B14', 'carteira 05')
            ->setCellValue('B15', 'carteira 07')
            ->setCellValue('B16', 'onboarding')
            ->setCellValue('B17', 'onboarding 2')
            ->setCellValue('B18', 'sem carteira')
            ->setCellValue('B19', 'total');










        $sheet->setCellValue('A21', 'ID')
            ->setCellValue('B21', 'Cnpj')
            ->setCellValue('C21', 'Empresa')
            ->setCellValue('D21', 'ID Cliente')
            ->setCellValue('E21', 'motivo')
            ->setCellValue('F21', 'Data Encerramento')
            ->setCellValue('G21', 'Plano')
            ->setCellValue('H21', 'Competencia')
            ->setCellValue('I21', 'Regime tributário')
            ->setCellValue('J21', 'Carteiras');

        $sheet->getStyle("A21:J21")->getFont()->setBold(true);
        $i = 22;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        $totalMovivo = [];
        $totalcartMovivo = [];



        foreach ($data as $item) {
            $carteiras = '';


            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('j')->setWidth($tamanhoH * 12);
            }
            $cat = null;

            foreach ($item->carteirasrel as $carteira) {
                $cat = $carteira->id;
                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }
            if (isset($item->motivo_desativacao->motivo)) {
                if (!isset($totalcartMovivo[$cat][$item->motivo_desativacao->motivo])) {
                    $totalcartMovivo[$cat][$item->motivo_desativacao->motivo] = 0;
                }
                $totalcartMovivo[$cat][$item->motivo_desativacao->motivo] =  $totalcartMovivo[$cat][$item->motivo_desativacao->motivo]  + 1;
            }

            if ($item->razao_social == null) {
                $pre =       Empresa::query()->withTrashed()->with('precadastro')->where('id', $item->empresas_id)->first();
                $item->razao_social = $pre->precadastro->empresa['razao_social'][0] ?? null;
            }
            if (isset($item->motivo_desativacao->motivo)) {

                if (!isset($totalMovivo[$item->motivo_desativacao->motivo])) {
                    $totalMovivo[$item->motivo_desativacao->motivo] = 0;
                }
                if ($item->motivo_desativacao->motivo == "Falhas operacionais") {
                    if (isset($item->motivo_desativacao->motivo)) {
                        $totalMovivo['Transferência outro contador'] = 0;
                    } else {
                        $totalMovivo['Transferência outro contador'] =  $totalMovivo['Transferência outro contador']  + 1;
                    }
                } else {
                    $totalMovivo[$item->motivo_desativacao->motivo] =  $totalMovivo[$item->motivo_desativacao->motivo]  + 1;
                }
            }


            $sheet->setCellValue('D4', $totalMovivo['Baixa da empresa'] ?? 0)
                ->setCellValue('D5',  $totalMovivo['Encerramento'] ?? 0)
                ->setCellValue('D6', $totalMovivo['Substituição do CNPJ'] ?? 0)
                ->setCellValue('D7', $totalMovivo['Transferência outro contador'] ?? 0);




            $sheet->setCellValue('C10', $totalcartMovivo[1]['Transferência outro contador'] ?? 0)
                ->setCellValue('D10',  $totalcartMovivo[1]['Encerramento'] ?? 0)
                ->setCellValue('E10', $totalcartMovivo[1]['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F10', $totalcartMovivo[1]['Baixa da empresa'] ?? 0);


            $sheet->setCellValue('C11', $totalcartMovivo[2]['Transferência outro contador'] ?? 0)
                ->setCellValue('D11',  $totalcartMovivo[2]['Encerramento'] ?? 0)
                ->setCellValue('E11', $totalcartMovivo[2]['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F11', $totalcartMovivo[2]['Baixa da empresa'] ?? 0);


            $sheet->setCellValue('C12', $totalcartMovivo[3]['Transferência outro contador'] ?? 0)
                ->setCellValue('D12',  $totalcartMovivo[3]['Encerramento'] ?? 0)
                ->setCellValue('E12', $totalcartMovivo[3]['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F12', $totalcartMovivo[3]['Baixa da empresa'] ?? 0);


            $sheet->setCellValue('C13', $totalcartMovivo[7]['Transferência outro contador'] ?? 0)
                ->setCellValue('D13',  $totalcartMovivo[7]['Encerramento'] ?? 0)
                ->setCellValue('E13', $totalcartMovivo[7]['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F13', $totalcartMovivo[7]['Baixa da empresa'] ?? 0);


            $sheet->setCellValue('C14', $totalcartMovivo[12]['Transferência outro contador'] ?? 0)
                ->setCellValue('D14',  $totalcartMovivo[12]['Encerramento'] ?? 0)
                ->setCellValue('E14', $totalcartMovivo[12]['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F14', $totalcartMovivo[12]['Baixa da empresa'] ?? 0);


            $sheet->setCellValue('C15', $totalcartMovivo[17]['Transferência outro contador'] ?? 0)
                ->setCellValue('D15',  $totalcartMovivo[17]['Encerramento'] ?? 0)
                ->setCellValue('E15', $totalcartMovivo[17]['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F15', $totalcartMovivo[17]['Baixa da empresa'] ?? 0);

            $sheet->setCellValue('C16', $totalcartMovivo[10]['Transferência outro contador'] ?? 0)
                ->setCellValue('D16',  $totalcartMovivo[10]['Encerramento'] ?? 0)
                ->setCellValue('E16', $totalcartMovivo[10]['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F16', $totalcartMovivo[10]['Baixa da empresa'] ?? 0);


            $sheet->setCellValue('C17', $totalcartMovivo[16]['Transferência outro contador'] ?? 0)
                ->setCellValue('D17',  $totalcartMovivo[16]['Encerramento'] ?? 0)
                ->setCellValue('E17', $totalcartMovivo[16]['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F17', $totalcartMovivo[16]['Baixa da empresa'] ?? 0);

            $sheet->setCellValue('C18', $totalcartMovivo['']['Transferência outro contador'] ?? 0)
                ->setCellValue('D18',  $totalcartMovivo['']['Encerramento'] ?? 0)
                ->setCellValue('E18', $totalcartMovivo['']['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F18', $totalcartMovivo['']['Baixa da empresa'] ?? 0);





            $sheet->setCellValue('C19', $totalMovivo['Transferência outro contador'] ?? 0)
                ->setCellValue('D19',  $totalMovivo['Encerramento'] ?? 0)
                ->setCellValue('E19', $totalMovivo['Substituição do CNPJ'] ?? 0)
                ->setCellValue('F19',  $totalMovivo['Baixa da empresa'] ?? 0);






            $sheet->setCellValue('A' . $i, $item->empresas_id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, ($item->razao_social == null ? $item->nome_empresa : $item->razao_social))
                ->setCellValue('D' . $i, $item->clientes_id . ' ' . $item->nome_cliente)
                ->setCellValue('E' . $i, !isset($item->motivo_desativacao->motivo) ? '' : $item->motivo_desativacao->motivo)
                ->setCellValue('F' . $i, $item->motivo_desativacao == null ? '' : Carbon::parse($item->motivo_desativacao->data_encerramento)->format('d/m/Y'))
                ->setCellValue('G' . $i, isset($item->plans[0]->price) ? $item->plans[0]->price : null)
                ->setCellValue('H' . $i, !isset($item->motivo_desativacao->data_competencia) ? '' :  Carbon::parse($item->motivo_desativacao->data_competencia)->format('d/m/Y'))
                ->setCellValue('I' . $i, $item->regime_tributario)
                ->setCellValue('J' . $i, $carteiras);
            $i++;
        }
        // return $totalcartMovivo[''];
        $sheet->getStyle("G4:H" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:H' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename), $filename);
    }


    public function relatorioSemContratos()
    {
        // ini_set('max_execution_time', 180); //3 minutes
        // ini_set ("memory_limit", "10056M");
        $data = $this->consultaSemContratos();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Empresas Sem Contrato Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Empresas Sem Contrato');

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:C1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(20);



        $sheet->setCellValue('A3', 'ID')
            ->setCellValue('B3', 'Cnpj')
            ->setCellValue('C3', 'empresa')
            ->setCellValue('D3', 'Carteiras');

        $sheet->getStyle("A3:C3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;

        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('H')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, ($item->nome_empresa == null ? $item->razao_social : $item->nome_empresa))
                ->setCellValue('D' . $i, $carteiras);
            $i++;
        }


        $sheet->getStyle("D1:D" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:C' . intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioEmpresaPlanoAnualCong()
    {

        $data = $this->consultaCongeladosPlanosAnual();
        return $this->funcaoRelatorioClientexFaturaCongelados($data);
    }

    public function relatorioClienteXFatura()
    {

        $data = $this->consultaClienteXFatura();
        return $this->funcaoRelatorioClientexFatura($data);
    }

    public function relatorioClienteXFaturaCartao()
    {

        $data = $this->consultaPagantesCartao();
        return $this->funcaoRelatorioClientexFatura($data);
    }

    public function funcaoRelatorioClientexFatura($data)
    {


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Cliente x Fatura Medb.xlsx';


        $sheet->setCellValue('A1', 'Relatorio Cliente x Fatura Medb');

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:H1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(25);



        $sheet->setCellValue('A3', 'ID')
            ->setCellValue('B3', 'Cnpj')
            ->setCellValue('C3', 'Empresa')
            ->setCellValue('D3', 'status')
            ->setCellValue('E3', 'Fatura')
            ->setCellValue('F3', 'Valor')
            ->setCellValue('G3', 'Data Pagou')
            ->setCellValue('H3', 'Gerou')
            ->setCellValue('I3', 'Carteiras')
            ->setCellValue('J3', 'Tipo Cobrança');


        $sheet->getStyle("A3:H3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;

        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('I')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, ($item->nome_empresa == null ? $item->razao_social : $item->nome_empresa))
                ->setCellValue('D' . $i, $this->status[$item->status_id])
                ->setCellValue('E' . $i, isset($item->fatura->id) ? $item->fatura->id : 'sem fatura')
                ->setCellValue('F' . $i, isset($item->fatura->id) ? $item->fatura->subtotal : 0)
                ->setCellValue('G' . $i, isset($item->fatura->id) ? $item->fatura->data_recebimento : 'sem fatura')
                ->setCellValue('H' . $i, isset($item->fatura->id) ? 'sim' : 'não')
                ->setCellValue('I' . $i, $carteiras);
            if (isset($item->fatura->id)) {
                $sheet->setCellValue('J' . $i,  $item->fatura->tipo_cobrancas_id > 0 ?  TipoCobranca::where('id', $item->fatura->tipo_cobrancas_id)->first()->nome : 'honorario');
            }
            $i++;
        }


        $sheet->getStyle("C4:H" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:H' . intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function funcaoRelatorioClientexFaturaCongelados($data)
    {


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Cliente x Fatura Congelados Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Cliente x Fatura Congelados Medb');

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:H1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(35);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('i')->setWidth(25);


        $sheet->setCellValue('A3', 'ID')
            ->setCellValue('B3', 'Cnpj')
            ->setCellValue('C3', 'Empresa')
            ->setCellValue('D3', 'status')
            ->setCellValue('E3', 'Descricao')
            ->setCellValue('F3', 'Valor')
            ->setCellValue('G3', 'Data Pagou')
            ->setCellValue('H3', 'Gerou')
            ->setCellValue('I3', 'Carteiras');

        $sheet->getStyle("A3:H3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;

        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('I')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, ($item->nome_empresa == null ? $item->razao_social : $item->nome_empresa))
                ->setCellValue('D' . $i, $this->status[$item->status_id])
                ->setCellValue('E' . $i, isset($item->faturaAnualCong->id) ? $item->faturaAnualCong->descricao : 'sem fatura')
                ->setCellValue('F' . $i, isset($item->faturaAnualCong->id) ? $item->faturaAnualCong->subtotal : 0)
                ->setCellValue('G' . $i, isset($item->faturaAnualCong->id) ? $item->faturaAnualCong->data_recebimento : 'sem fatura')
                ->setCellValue('H' . $i, isset($item->faturaAnualCong->id) ? 'sim' : 'não')

                ->setCellValue('I' . $i, $carteiras);

            $i++;
        }


        $sheet->getStyle("C4:H" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:H' . intval($i));

        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioSemCrm(CrmRepository $crmRepository)
    {
        $data = $this->consultaSemCrm($crmRepository);

        // return $data;

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Sem crm Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Sem crm Medb');

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:D1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        // $sheet->getColumnDimension('D')->setWidth(12);

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Carteiras');

        $sheet->getStyle("A3:D3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('D')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }


            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, $item->getName())
                ->setCellValue('D' . $i,  $carteiras);

            $i++;
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:D' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioEmpresasSemCrmJuridico(CrmRepository $crmRepository)
    {
        $data = $this->consultaSemCrmPJ($crmRepository);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Sem crm PJ Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Sem crm PJ Medb');

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:D1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        // $sheet->getColumnDimension('D')->setWidth();

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Carteiras');

        $sheet->getStyle("A3:D3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('D')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, $item->getName())
                ->setCellValue('D' . $i,  $carteiras);

            $i++;
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:D' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioEmpresasComCrmJuridico(CrmRepository $crmRepository)
    {
        $data = $this->consultaComCrmPJ($crmRepository);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Com crm PJ Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Com crm PJ Medb');

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:D1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        // $sheet->getColumnDimension('D')->setWidth();

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Carteiras');

        $sheet->getStyle("A3:D3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('D')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, $item->getName())
                ->setCellValue('D' . $i,  $carteiras);

            $i++;
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:D' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioEmpresasPlanosDeleted()
    {
        $data = $this->consultaEmpresasPlanosDeleted();
        // return $data;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Empresas Planos ocultos  Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio  Empresas Planos ocultos  Medb');

        $sheet->getStyle("A1:C1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:C1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:C1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(60);
        $sheet->getColumnDimension('C')->setWidth(15);

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Empresa');
        $sheet->setCellValue('C3', 'Price');

        $sheet->getStyle("A3:C3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, $item->nome_empresa == null ? $item->razao_social : $item->nome_empresa)
                ->setCellValue('C' . $i, $item->price);
            $i++;
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:C' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function RelatorioEmpresaSemAlvara()
    {
        $data = $this->ConsultaEmpresaSemAlvara();
        // return $data;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Empresas Sem alvara Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Empresas Sem alvara Medb');

        $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:E1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:E1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Alvara');
        $sheet->setCellValue('E3', 'Carteiras');


        $sheet->getStyle("A3:E3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('H')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }


            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, $item->getName())
                ->setCellValue('D' . $i, 'sem alvara')
                ->setCellValue('E' . $i,   $carteiras);

            $i++;
            $sheet->getStyle("a" . intval($i))->getAlignment()->setHorizontal('center');
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');


        $sheet->getPageSetup()->setPrintArea('A1:F' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioEmpresasResidente()
    {
        $data = $this->consultaEmpresasResidentes();
        // return $data;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Empresas Residentes Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Empresas Residentes Medb');

        $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:E1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:E1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

        // $sheet->getColumnDimension('D')->setWidth(17);
        // $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Price');
        $sheet->setCellValue('E3', 'Carteiras');




        $sheet->getStyle("A3:E3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('E')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }


            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, $item->nome_empresa == null ? $item->razao_social : $item->nome_empresa)
                ->setCellValue('D' . $i, $item->plans()->sum('price'))
                ->setCellValue('E' . $i, $carteiras);

            $i++;
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:E' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }


    //
    public function relatorioPrevisoesAtivas()
    {
        $empresas = Empresa::where('status_id', '<>', 71)
            ->join('plan_subscriptions', 'plan_subscriptions.payer_id', 'empresas.id')
            ->leftjoin('plans', 'plans.id', 'plan_subscriptions.plan_id')
            // ->whereNull('plan_subscriptions.deleted_at')
            ->select('empresas.created_at', 'empresas.id', 'empresas.status_id', 'empresas.cnpj', 'empresas.razao_social', 'empresas.nome_empresa', 'plans.price as valor', 'plans.id as plans_id', 'plans.updated_at as plan_create')
            ->get();


        foreach ($empresas as $at) {
            if ($at->status_id  != 81) {
                $ativas[] = $at;
            }
            if ($at->status_id == 100 or $at->status_id == 80 or $at->status_id == 70) {
            } else {
                if ($at->status_id  == 81) {


                    $congeladas[] = $at;
                } else {

                    $abertura[] = $at;
                }
            }
        }

        // foreach ($empresas as $at) {
        //     if ($at->status_id != 100 and $at->status_id != 99 and $at->status_id != 80 and $at->status_id != 80){
        //         $ativas[] = $at;
        //     }
        // }
        $j = 0;
        $data = [$ativas, $abertura, $congeladas];
        // return $data;
        $spreadsheet = new Spreadsheet();

        foreach ($data as $col) {
            $previstoABAT = [];
            $fatEsperado = 0;
            $spreadsheet->setActiveSheetIndex($j);
            $sheet = $spreadsheet->getActiveSheet();

            $filename = 'Relatorio Empresas Previsões Medb.xlsx';

            // $sheet->setCellValue('A1', 'Relatorio  Empresas Ativas Previsões  Medb');

            switch ($j) {
                case 0:
                    $sheet->setTitle('Ativas');
                    $sheet->setCellValue('A1', 'Relatorio Empresas Ativas Previsões  Medb');

                    break;
                case 1:
                    $sheet->setTitle('Abertura');
                    $sheet->setCellValue('A1', 'Relatorio Empresas Abertura Previsões ');

                    break;
                case 2:
                    $sheet->setTitle('Congeladas');
                    $sheet->setCellValue('A1', 'Relatorio Empresas Congeladas Previsões');

                    break;
            }


            $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("A1:E1")->getFont()->setSize(18);
            $sheet->mergeCells('A1:E1');

            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(60);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(20);



            $sheet->setCellValue('A3', 'ID');
            $sheet->setCellValue('B3', 'Empresa');
            $sheet->setCellValue('C3', 'CNPJ');
            $sheet->setCellValue('D3', 'Price');
            $sheet->setCellValue('E3', 'Carteiras');

            $sheet->getStyle("A3:H3")->getFont()->setBold(true);
            $i = 4;
            $tamanhoH = 0;
            foreach ($col as $item) {

                $carteiras = '';
                if ($item->status_id == 100 and $j == 0) {

                    if (count($item->carteirasrel) >   $tamanhoH) {
                        if (count($item->carteirasrel) > $tamanhoH) {
                            $tamanhoH = count($item->carteirasrel);
                        }

                        switch ($j) {
                            case 0:
                                $sheet->getColumnDimension('E')->setWidth($tamanhoH * 11);
                                break;
                            case 1:
                                $sheet->getColumnDimension('E')->setWidth($tamanhoH * 14);
                                break;
                        }
                    }
                    foreach ($item->carteirasrel as $carteira) {

                        if ($carteiras != '') {
                            $carteiras = $carteira->nome . ' - ' . $carteiras;
                        }
                        if ($carteiras == '') {
                            $carteiras = $carteira->nome;
                        }
                    }

                    $fatEsperado += $item->valor;


                    $sheet->setCellValue('A' . $i, $item->id)
                        ->setCellValue('B' . $i, ' ' . $item->cnpj)
                        ->setCellValue('C' . $i, $item->getName())
                        ->setCellValue('D' . $i, ' R$ ' . number_format($item->valor, 2, ',', '.'))
                        ->setCellValue('E' . $i, $carteiras);




                    $i++;
                } else  if ($j == 1) {
                    $sheet->setCellValue('F3', 'Data Entrada');
                    if (count($item->carteirasrel) >   $tamanhoH) {
                        if (count($item->carteirasrel) > $tamanhoH) {
                            $tamanhoH = count($item->carteirasrel);
                        }

                        switch ($j) {
                            case 0:
                                $sheet->getColumnDimension('E')->setWidth($tamanhoH * 11);
                                break;
                            case 1:
                                $sheet->getColumnDimension('E')->setWidth($tamanhoH * 14);
                                break;
                        }
                    }
                    foreach ($item->carteirasrel as $carteira) {

                        if ($carteiras != '') {
                            $carteiras = $carteira->nome . ' - ' . $carteiras;
                        }
                        if ($carteiras == '') {
                            $carteiras = $carteira->nome;
                        }
                    }

                    $fatEsperado += $item->valor;


                    $sheet->setCellValue('A' . $i, $item->id)
                        ->setCellValue('B' . $i, ' ' . $item->cnpj)
                        ->setCellValue('C' . $i, $item->getName())
                        ->setCellValue('D' . $i, ' R$ ' . number_format($item->valor, 2, ',', '.'))
                        ->setCellValue('E' . $i, $carteiras)
                        ->setCellValue('F' . $i, Carbon::parse($item->created_at)->format('d/m/Y'));


                    $i++;
                } else  if ($j == 2) {
                    $sheet->getColumnDimension('F')->setWidth(22);

                    $sheet->setCellValue('F3', 'Data Ultima Fatura');
                    if (count($item->carteirasrel) >   $tamanhoH) {
                        if (count($item->carteirasrel) > $tamanhoH) {
                            $tamanhoH = count($item->carteirasrel);
                        }

                        switch ($j) {
                            case 0:
                                $sheet->getColumnDimension('E')->setWidth($tamanhoH * 11);
                                break;
                            case 1:
                                $sheet->getColumnDimension('E')->setWidth($tamanhoH * 14);
                                break;
                        }
                    }
                    foreach ($item->carteirasrel as $carteira) {

                        if ($carteiras != '') {
                            $carteiras = $carteira->nome . ' - ' . $carteiras;
                        }
                        if ($carteiras == '') {
                            $carteiras = $carteira->nome;
                        }
                    }

                    $fatEsperado += $item->valor;

                    $sheet->setCellValue('A' . $i, $item->id)
                        ->setCellValue('B' . $i, ' ' . $item->cnpj)
                        ->setCellValue('C' . $i, $item->getName())
                        ->setCellValue('D' . $i, ' R$ ' . number_format($item->valor, 2, ',', '.'))
                        ->setCellValue('E' . $i, $carteiras)
                        ->setCellValue('F' . $i, isset($item->ultfatura->created_at) ? Carbon::parse($item->ultfatura->created_at)->format('d/m/Y') : '');




                    $i++;
                }

                if ($item->status_id != 100 and $item->status_id != 81) {
                    // $dataAtivaPrevista =  Carbon::parse($item->updated_at)->addMonths(2)->format('m');
                    // return $dataAtivaPrevista;

                    // if ($dataAtivaPrevista <= Carbon::now()->format('m')) {
                    $dataAtivaPrevista = Carbon::parse($item->created_at)->addMonths(2)->format('m') >= Carbon::now()->format('m')  ? Carbon::now()->addMonths(1)->format('m') : Carbon::now()->addMonths(2)->format('m');
                    // }
                    // return $dataAtivaPrevista ;
                    $previstoABAT[$dataAtivaPrevista][] = $item->valor;
                } else if ($item->status_id == 81) {

                    switch ($item->plans_id) {
                        case 10:
                            $dataAtivaPrevista =  isset($item->ultfatura->created_at) ?  Carbon::parse($item->ultfatura->created_at)->addMonths(6)->format('m') : '';
                            // return $dataAtivaPrevista;

                            break;
                        case 11:
                            $dataAtivaPrevista =   Carbon::now()->setMonth(4)->format('m');
                            break;
                    }
                    $previstoABAT[$dataAtivaPrevista][] = $item->valor;
                    // return  $item;

                }
            }
            // return $previstoABAT;

            switch ($j) {
                case 0:

                    setlocale(LC_TIME, 'ptb'); // LC_TIME é formatação de data e hora com strftime()

                    $sheet->getColumnDimension('G')->setWidth(12);
                    $sheet->getColumnDimension('H')->setWidth(48);
                    // $sheet->getColumnDimension('I')->setWidth(20);
                    $sheet->getStyle("h2")->getFont()->setBold(true);

                    $sheet->setCellValue('H2', 'Faturamento Previsto para cada mes conforme as ativas');
                    $sheet->setCellValue('H3', 'e aberturas prevista com finalizacao');

                    // $sheet->mergeCells('H2:H3');
                    $sheet->setCellValue('G3', 'Meses');


                    $sheet->getStyle("h18")->getFont()->setBold(true);

                    $sheet->setCellValue('h18', 'Quantidades de Faturas : ' . intval($i - 4));



                    $linhaP = 4;
                    $corn = 0;
                    $cor = 0;
                    // return $previstoABAT;
                    $presoma = $fatEsperado;
                    for ($k = 0; $k < 12; $k++) {

                        $dt = $k == 0 ? Carbon::now() : Carbon::now()->addMonths($k);

                        //    return  $previstoABAT;

                        $sheet->setCellValue('G' . intval($linhaP), utf8_encode($dt->formatLocalized('%B')));
                        if (isset($previstoABAT[$dt->format('m')])) {
                            $fatEsperado  = array_sum($previstoABAT[$dt->format('m')]) +  $fatEsperado;
                        }
                        $presoma =   $fatEsperado;
                        // $sheet->mergeCells('H2:I2');
                        // $sheet->mergeCells('H3:I3');
                        // $cor =  $corn == 0 ? '78f100' :  $corn < 99 ? '00FF'
                        $sheet->setCellValue('H' . intval($linhaP), 'Faturamento Esperado: ' . ' R$ ' . number_format($presoma, 2, '.', ','));
                        $spreadsheet->getActiveSheet()->getStyle('G' . intval($linhaP) . ':H' . intval($linhaP))->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('96ff5c');
                        $linhaP++;

                        // $corn = intval($cor) + 10;
                    }


                    break;
                case 1:
                    $sheet->getStyle("G5")->getFont()->setBold(true);

                    $sheet->setCellValue('G5', 'Quantidades de Faturas : ' . intval($i - 4));


                    $sheet->getColumnDimension('G')->setWidth(30);
                    $sheet->getColumnDimension('H')->setWidth(22);
                    $sheet->setTitle('Abertura');
                    $sheet->setCellValue('G2', 'Faturamento Previsto para cada mes conforme as em Abertura');
                    $sheet->setCellValue('G3', 'Faturamento Esperado: ' . ' R$ ' . number_format($fatEsperado, 2, '.', ','));
                    $sheet->mergeCells('G2:H2');
                    $sheet->mergeCells('G3:H3');
                    $spreadsheet->getActiveSheet()->getStyle('G3:H3')->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00FF00');
                    break;

                case 2:
                    $sheet->getStyle("H3")->getFont()->setBold(true);

                    $sheet->setCellValue('H3', 'Quantidades de Faturas : ' . intval($i - 4));


                    $sheet->getColumnDimension('G')->setWidth(12);
                    $sheet->getColumnDimension('H')->setWidth(50);
                    // $sheet->getColumnDimension('I')->setWidth(20);
                    $sheet->getStyle("h2")->getFont()->setBold(true);

                    $sheet->setCellValue('H2', 'Faturamento Previsto para cada mes conforme as congeladas');


                    // $sheet->mergeCells('H2:H3');
                    $sheet->setCellValue('G3', 'Meses');

                    $linhaP = 4;
                    $corn = 0;
                    $cor = 0;
                    // return $previstoABAT;
                    $presoma = $fatEsperado;
                    for ($k = 0; $k < 8; $k++) {

                        $dt = $k == 0 ? Carbon::now() : Carbon::now()->addMonths($k);

                        //    return  $previstoABAT;

                        $sheet->setCellValue('G' . intval($linhaP), utf8_encode($dt->formatLocalized('%B')));
                        if (isset($previstoABAT[$dt->format('m')])) {
                            $fatEsperado  = array_sum($previstoABAT[$dt->format('m')]);

                            $presoma =   $fatEsperado;
                            // $sheet->mergeCells('H2:I2');
                            // $sheet->mergeCells('H3:I3');
                            // $cor =  $corn == 0 ? '78f100' :  $corn < 99 ? '00FF'


                            $sheet->setCellValue('H' . intval($linhaP), 'Faturamento Esperado: ' . ' R$ ' . number_format($presoma, 2, '.', ','));
                        }
                        $spreadsheet->getActiveSheet()->getStyle('G' . intval($linhaP) . ':H' . intval($linhaP))->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('96ff5c');
                        $linhaP++;
                    }
                    break;
            }

            $sheet->getStyle("G2:I15")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("E4:E" . intval($i))->getAlignment()->setHorizontal('center');
            $sheet->getStyle("F4:F" . intval($i))->getAlignment()->setHorizontal('center');




            $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

            $sheet->getPageSetup()->setPrintArea('A1:H' . intval($i));
            $spreadsheet->createSheet();
            $j++;
        }


        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }


    public function consultaComissao($request)
    {
        $data = '';
        if ($request->usuario != []) {


            $data =  Empresa::query()->with('priTreefatura')

                ->join('empresa_pre_cadastros', 'empresa_pre_cadastros.empresa_id', 'empresas.id')
                ->join('usuarios', 'usuarios.id', 'empresa_pre_cadastros.usuario_id')
                ->leftjoin('contratos', 'contratos.empresas_id', 'empresa_pre_cadastros.empresa_id')


                ->whereNotIn('empresas.status_id', [71])
                ->where('empresas.saiu', 0)


                ->where('empresa_pre_cadastros.usuario_id', $request->usuario)
                // ->where('contratos.signed_at','>',Carbon::now()->setDay(1)->format('Y-m-d'))

                ->select('usuarios.nome_completo as nome_usuario', 'empresas.*')->get();
        } else if (count($request->usuario) == 0) {

            // return 'tem que entrar aqui';
            $data =  Empresa::query()->with('priTreefatura')

                ->join('empresa_pre_cadastros', 'empresa_pre_cadastros.empresa_id', 'empresas.id')
                ->join('usuarios', 'usuarios.id', 'empresa_pre_cadastros.usuario_id')
                ->leftjoin('contratos', 'contratos.empresas_id', 'empresa_pre_cadastros.empresa_id')


                ->whereNotIn('empresas.status_id', [71])
                ->where('empresas.saiu', 0)


                // ->where('contratos.signed_at','>',Carbon::now()->setDay(1)->format('Y-m-d'))

                ->select('usuarios.nome_completo as nome_usuario', 'empresas.*')->get();
        }

        return $data;
    }

    public function relatorioComissoes(Request $request)
    {

        $data  = $this->consultaComissao($request);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Comissões  Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Comissões Medb');

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:I1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(11);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(8);
        $sheet->getColumnDimension('E')->setWidth(16);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(9);
        $sheet->getColumnDimension('I')->setWidth(11);
        $sheet->getColumnDimension('J')->setWidth(8);
        $sheet->getColumnDimension('K')->setWidth(4);
        $sheet->getColumnDimension('L')->setWidth(9);
        $sheet->getColumnDimension('M')->setWidth(11);
        $sheet->getColumnDimension('N')->setWidth(8);
        $sheet->getColumnDimension('O')->setWidth(4);
        $sheet->getColumnDimension('P')->setWidth(9);
        $sheet->getColumnDimension('Q')->setWidth(11);
        $sheet->getColumnDimension('R')->setWidth(8);


        setlocale(LC_TIME, 'ptb'); // LC_TIME é formatação de data e hora com strftime()

        $sheet->setCellValue('A3', 'Usuario');
        $sheet->setCellValue('B3', 'Id Empresa');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Plano');
        $sheet->setCellValue('E3', 'Contrato Assinado');
        $sheet->setCellValue('F3', 'status');
        $sheet->setCellValue('G3', 'Carteiras');

        $sheet->setCellValue('H3', 'Status');
        $sheet->setCellValue('I3', '01/Parcela');
        $sheet->setCellValue('J3', 'valor');



        $sheet->setCellValue('L3', 'Status');
        $sheet->setCellValue('M3', '02/Parcela');
        $sheet->setCellValue('N3', 'valor');


        $sheet->setCellValue('P3', 'Status');
        $sheet->setCellValue('Q3', '03/Parcela');
        $sheet->setCellValue('R3', 'valor');

        // $sheet->setCellValue('F3', utf8_encode($dt[0]->formatLocalized('%B')));
        // $sheet->setCellValue('G3', utf8_encode($dt[1]->formatLocalized('%B')));
        // $sheet->setCellValue('H3', utf8_encode($dt[2]->formatLocalized('%B')));


        $sheet->getStyle("A3:R3")->getFont()->setBold(true);
        $sheet->getStyle("A3:R3")->getAlignment()->setHorizontal('left');
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;

        foreach ($data as $item) {

            $soma = 0;
            $pri = 0;

            $carteiras = '';
            if ($item->plans()->sum('price') >  0) {



                if (isset($item->contrato->signed_at) && Carbon::parse($item->contrato->signed_at)->format('Y-m') < Carbon::now()->format('Y-m')) {


                    if (isset($item->priTreefatura[0])) {
                        foreach ($item->priTreefatura as $fat) {

                            $soma += $fat->status == 'pago' ? 1  : 0;
                            if ($pri == 0) {
                                $pri  = $fat->status == 'pago' ? 1  : 0;
                            }
                        }
                    }

                    if ($soma < 3  and $pri == 1) {



                        $dt[0] = isset($item->priTreefatura[0]) ? Carbon::parse($item->priTreefatura[0]->data_competencia)->addMonths(1) : 'sem fatura';
                        $dt[1] =   isset($item->priTreefatura[1]) ? Carbon::parse($item->priTreefatura[1]->data_competencia)->addMonths(1) : 'sem fatura';
                        $dt[2] =    isset($item->priTreefatura[2]) ? Carbon::parse($item->priTreefatura[2]->data_competencia)->addMonths(1) : 'sem fatura';



                        if (count($item->carteirasrel) >   $tamanhoH) {
                            $tamanhoH = count($item->carteirasrel);

                            $sheet->getColumnDimension('G')->setWidth($tamanhoH * 10);
                        }
                        foreach ($item->carteirasrel as $carteira) {

                            if ($carteiras != '') {
                                $carteiras = $carteira->nome . ' - ' . $carteiras;
                            }
                            if ($carteiras == '') {
                                $carteiras = $carteira->nome;
                            }
                        }

                        $sheet->setCellValue('A' . $i, $item->nome_usuario)
                            ->setCellValue('B' . $i, $item->id)
                            ->setCellValue('C' . $i, $item->getName())
                            ->setCellValue('D' . $i, $item->plans()->sum('price'))
                            ->setCellValue('E' . $i, Carbon::parse($item->contrato->signed_at)->format('d/m/Y'))
                            ->setCellValue('F' . $i, $item->status_label)
                            ->setCellValue('G' . $i, $carteiras);


                        if (isset($item->priTreefatura[0])) {
                            $sheet->setCellValue('H' . $i, $item->priTreefatura[0]->status)
                                ->setCellValue('I' . $i,  utf8_encode($dt[0]->formatLocalized('%B')));


                            if (isset($item->priTreefatura[1])) {
                                $sheet->setCellValue('L' . $i, isset($item->priTreefatura[1]) ? $item->priTreefatura[1]->status : 'Sem fatura')
                                    ->setCellValue('M' . $i, $dt[1] == 'Sem fatura' ? $dt[1] :   utf8_encode($dt[1]->formatLocalized('%B')));
                            } else {
                                $sheet->mergeCells('L' . $i . ':N' . $i)->setCellValue('L' . $i, 'Sem fatura');
                                $sheet->getStyle('L' . $i . ':N' . $i)->getAlignment()->setHorizontal('center');
                            }

                            if (isset($item->priTreefatura[2])) {
                                $sheet->setCellValue('P' . $i, isset($item->priTreefatura[2]) ? $item->priTreefatura[2]->status : 'Sem fatura')
                                    ->setCellValue('Q' . $i, $dt[2] == 'Sem fatura' ? $dt[2] :  utf8_encode($dt[2]->formatLocalized('%B')));
                            } else {
                                $sheet->mergeCells('P' . $i . ':R' . $i)->setCellValue('P' . $i, 'Sem fatura');
                                $sheet->getStyle('P' . $i . ':R' . $i)->getAlignment()->setHorizontal('center');
                            }
                        } else {
                            $sheet->mergeCells('H' . $i . ':I' . $i)->setCellValue('H' . $i, 'Sem fatura');
                            $sheet->mergeCells('L' . $i . ':M' . $i)->setCellValue('L' . $i, 'Sem fatura');
                            $sheet->mergeCells('P' . $i . ':Q' . $i)->setCellValue('P' . $i, 'Sem fatura');
                            $sheet->getStyle('H' . $i . ':I' . $i)->getAlignment()->setHorizontal('center');
                            $sheet->getStyle('L' . $i . ':M' . $i)->getAlignment()->setHorizontal('center');
                            $sheet->getStyle('P' . $i . ':Q' . $i)->getAlignment()->setHorizontal('center');
                        }
                        $sheet->setCellValue('J' . $i,  formata_moeda(($item->plans()->sum('price') * 0.35) / 3));

                        $sheet->setCellValue('N' . $i,  formata_moeda(($item->plans()->sum('price') * 0.35) / 3));

                        $sheet->setCellValue('R' . $i,  formata_moeda(($item->plans()->sum('price') * 0.35) / 3));


                        // ->setCellValue('G' . $i, ($item->price*0.3)/3)
                        // ->setCellValue('H' . $i, ($item->price*0.3)/3);
                        $i++;
                    }
                }
            }
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('left');

        $sheet->getPageSetup()->setPrintArea('A1:C' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioComissoesExCongelados()
    {

        $data =  EmpresaPreCadastro::query()
            ->join('usuarios', 'usuarios.id', 'empresa_pre_cadastros.usuario_id')
            ->join('contratos', 'contratos.id', 'empresa_pre_cadastros.empresa_id')
            ->join('empresas', 'empresas.id', 'empresa_pre_cadastros.empresa_id')
            ->join('plan_subscriptions', 'plan_subscriptions.payer_id', 'empresa_pre_cadastros.empresa_id')
            ->join('plans', 'plans.id', 'plan_subscriptions.plan_id')
            ->join('empresas_usuarios_cong', 'empresas_usuarios_cong.empresas_id', 'empresa_pre_cadastros.empresa_id')
            // ->where('contratos.signed_at','>',Carbon::now()->setDay(1)->format('Y-m-d'))


            ->select('empresas_usuarios_cong.data_congelamento', 'plans.price', 'usuarios.nome_completo as nome_usuario', 'empresas.nome_empresa', 'empresas.razao_social', 'empresa_pre_cadastros.empresa_id', 'contratos.signed_at')->get();


        // return $data;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Comissões  Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Comissões Medb');

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:I1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(11);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(8);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);

        $sheet->getColumnDimension('G')->setWidth(17);
        $sheet->getColumnDimension('H')->setWidth(17);
        $sheet->getColumnDimension('I')->setWidth(17);

        setlocale(LC_TIME, 'ptb'); // LC_TIME é formatação de data e hora com strftime()

        //    return  $previstoABAT;

        $sheet->setCellValue('A3', 'Usuario');
        $sheet->setCellValue('B3', 'Id Empresa');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Plano');
        $sheet->setCellValue('E3', 'Contrato Assinado');
        $sheet->setCellValue('F3', 'Empresa Congelada');

        // $sheet->setCellValue('F3', utf8_encode($dt[0]->formatLocalized('%B')));
        // $sheet->setCellValue('G3', utf8_encode($dt[1]->formatLocalized('%B')));
        // $sheet->setCellValue('H3', utf8_encode($dt[2]->formatLocalized('%B')));


        $sheet->getStyle("A3:F3")->getFont()->setBold(true);
        $sheet->getStyle("A3:F3")->getAlignment()->setHorizontal('left');
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            if ($item->price > 0) {
                if (Carbon::parse($item->signed_at)->format('m') < Carbon::now()->setDay(1)->format('m')) {
                    if (Carbon::parse($item->data_congelamento)->format('Y-m-d') < Carbon::parse($item->signed_at)->setMonth(3)->format('Y-m-d')) {

                        $dt[0] = Carbon::parse($item->signed_at)->addMonths(1);
                        $dt[1] =  Carbon::parse($item->signed_at)->addMonths(2);
                        $dt[2] =  Carbon::parse($item->signed_at)->addMonths(3);

                        $sheet->setCellValue('A' . $i, $item->nome_usuario)
                            ->setCellValue('B' . $i, $item->empresa_id)
                            ->setCellValue('C' . $i, $item->nome_empresa == null ? $item->razao_social : $item->nome_empresa)
                            ->setCellValue('D' . $i, $item->price)
                            ->setCellValue('E' . $i, Carbon::parse($item->signed_at)->format('d/m/Y'))
                            ->setCellValue('F' . $i, Carbon::parse($item->data_congelamento)->format('d/m/Y'))


                            ->setCellValue('G' . $i, utf8_encode($dt[0]->formatLocalized('%B')) . ' ' . formata_moeda(($item->price * 0.35) / 3))
                            ->setCellValue('H' . $i, utf8_encode($dt[1]->formatLocalized('%B')) . ' ' . formata_moeda(($item->price * 0.35) / 3))
                            ->setCellValue('I' . $i, utf8_encode($dt[2]->formatLocalized('%B')) . ' ' . formata_moeda(($item->price * 0.35) / 3));


                        // ->setCellValue('G' . $i, ($item->price*0.3)/3)
                        // ->setCellValue('H' . $i, ($item->price*0.3)/3);
                        $i++;
                    }
                }
            }
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('left');

        $sheet->getPageSetup()->setPrintArea('A1:F' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }


    public function EmpresaAberturaDate(Request $request)
    {


        $data = Empresa::whereNotIn('status_id', ['71', '81', '100', '70', '80'])
            ->whereIn('status_id', $request->status)
            ->get();


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Empresas Aberturas.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Empresas Aberturas');

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:F1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(17);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(20);


        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'status');
        $sheet->setCellValue('E3', 'Carteiras');
        $sheet->setCellValue('F3', 'Data');



        $sheet->getStyle("A3:F3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {

            $carteiras = '';

            if ($item->updated_at <= Carbon::now()->subDays($request->quantDay)) {

                if (count($item->carteirasrel) >   $tamanhoH) {
                    $tamanhoH = count($item->carteirasrel);

                    $sheet->getColumnDimension('H')->setWidth($tamanhoH * 10);
                }
                foreach ($item->carteirasrel as $carteira) {

                    if ($carteiras != '') {
                        $carteiras = $carteira->nome . ' - ' . $carteiras;
                    }
                    if ($carteiras == '') {
                        $carteiras = $carteira->nome;
                    }
                }


                $sheet->setCellValue('A' . $i, $item->id)
                    ->setCellValue('B' . $i, ' ' . $item->cnpj)
                    ->setCellValue('C' . $i, $item->getName())
                    ->setCellValue('D' . $i, $item->status_label)
                    ->setCellValue('E' . $i,   $carteiras)
                    ->setCellValue('F' . $i,   Carbon::parse($item->updated_at)->format('d/m/Y'));


                $i++;

                $sheet->getStyle("A" . intval($i))->getAlignment()->setHorizontal('center');
            }
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');


        $sheet->getPageSetup()->setPrintArea('A1:F' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioDeOndeVeio(Request $request)
    {

        $params = $request->all();

        $data =  Fatura::query()->with('tipo_cobranca', 'payer')
            ->where('data_vencimento', '>=', Carbon::parse($params['date'])->format('Y-m-01'))
            ->where('data_vencimento', '<=',  Carbon::parse($params['date'])->format('Y-m-30'))
            ->where('status', 'pago')
            ->get();

        // return  response()->json($data,200);    

        $valores = ['honorario' => 0, 'juros' => 0, 'atrasado e Adicionais' => 0];

        foreach ($data as $item) {


            if (!isset($item->tipo_cobranca->nome)) {
                if ($item->subtotal >= 280 and $item->subtotal < 356) {
                    $valores['honorario'] =   $valores['honorario'] + 280;

                    $valores['juros'] =  ($item->subtotal - 280)  +  $valores['juros'];
                } else
                if ($item->subtotal >= 356 and $item->subtotal <= 400) {
                    $valores['honorario'] =   $valores['honorario'] + 356;

                    $valores['juros'] =   ($item->subtotal - 356) +    $valores['juros'];
                } else {
                    $valores['atrasado e Adicionais'] =   $valores['atrasado e Adicionais'] + $item->subtotal;
                }
            } else {


                if ($item->tipo_cobranca->nome != 'honorario') {
                    // $posicao ='';
                    // $posicao = $item->tipo_cobranca->nome;
                    if (!isset($valores[$item->tipo_cobranca->nome])) {
                        $valores = [$item->tipo_cobranca->nome => 0] + $valores;
                    }

                    $valores[$item->tipo_cobranca->nome]  = $item->subtotal +    $valores[$item->tipo_cobranca->nome];
                } else {
                    if ($item->subtotal >= 280 and $item->subtotal < 356) {
                        $valores['honorario'] =   $valores['honorario'] + 280;

                        $valores['juros'] =  ($item->subtotal - 280)  +  $valores['juros'];
                    }
                    if ($item->subtotal >= 356 and $item->subtotal <= 400) {
                        $valores['honorario'] =   $valores['honorario'] + 356;

                        $valores['juros'] =   ($item->subtotal - 356) +    $valores['juros'];
                    }
                }
            }
        }



        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Financeiro Medb.xlsx';


        $sheet->setCellValue('A1', 'Relatorio Cliente x Fatura Medb');

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:H1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(25);



        $sheet->setCellValue('A3', 'ID')
            ->setCellValue('B3', 'Cnpj')
            ->setCellValue('C3', 'Empresa')
            ->setCellValue('D3', 'status')
            ->setCellValue('E3', 'Fatura')
            ->setCellValue('F3', 'Valor')
            ->setCellValue('G3', 'Data Pagou')

            ->setCellValue('H3', 'Carteiras')
            ->setCellValue('I3', 'Tipo Cobrança');


        $sheet->getStyle("A3:H3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;

        foreach ($data as $item) {
            $carteiras = '';
            if (isset($item->payer->carteirasrel)) {
                // return $item;
                if (count($item->payer->carteirasrel) >   $tamanhoH) {
                    $tamanhoH = count($item->payer->carteirasrel);

                    $sheet->getColumnDimension('H')->setWidth($tamanhoH * 12);
                }
                foreach ($item->payer->carteirasrel as $carteira) {

                    if ($carteiras != '') {
                        $carteiras = $carteira->nome . ' - ' . $carteiras;
                    }
                    if ($carteiras == '') {
                        $carteiras = $carteira->nome;
                    }
                }
            }

            if (isset($item->payer->id)) {

                if ($item->status == 'pago') {
                    $sheet->setCellValue('A' . $i, $item->payer->id)
                        ->setCellValue('B' . $i, ' ' . $item->payer->cnpj)
                        ->setCellValue('C' . $i, $item->payer->getName())
                        ->setCellValue('D' . $i, $this->status[$item->payer->status_id] ?? null)
                        ->setCellValue('E' . $i,  $item->id)
                        ->setCellValue('F' . $i,  $item->subtotal)
                        ->setCellValue('G' . $i,   $item->data_recebimento)
                        ->setCellValue('H' . $i, $carteiras);
                    if (isset($item->fatura->id)) {
                    }
                    if (isset($item->tipo_cobranca->nome)) {
                        $sheet->setCellValue('I' . $i, $item->tipo_cobranca->nome);
                    } else {
                        $sheet->setCellValue('I' . $i, 'honorario');
                    }
                    $i++;
                }
            }
        }



        $letter = range('a', 'z');

        $l = 0;

        $sheet->setCellValue('A' .  strval($i + 2), 'Relatorio Financeiro  Medb');

        foreach ($valores as $key => $value) {

            // if ($key == 'serviços financeiros terceirizados') {
            //     $sheet->getColumnDimension($letter[$l])->setWidth(30);
            // } else {
            //     $sheet->getColumnDimension($letter[$l])->setWidth(20);
            // }


            $sheet->setCellValue($letter[$l] . strval($i + 3), $key);

            $sheet->setCellValue($letter[$l] . strval($i + 4), $value);
            $l++;
        }
        $sheet->getStyle($letter[0] .   strval($i + 2) . ':' . $letter[$l] . $l)->getAlignment()->setHorizontal('center');
        $sheet->getStyle($letter[0] .  strval($i + 2) . ':' . $letter[$l] .  strval($i + 2))->getFont()->setSize(18);
        $sheet->mergeCells($letter[0] .  strval($i + 2) . ':' . $letter[$l - 1] .  strval($i + 2));
        $sheet->getStyle($letter[0] .  strval($i + 2) . ':' . $letter[$l - 1] .  strval($i + 2))->getAlignment()->setHorizontal('center');

        $sheet->getStyle($letter[0] . strval($i + 3) . ':' .  $letter[$l] . strval($i + 3))->getFont()->setBold(true);




        // return response()->json($valores, 200);
        // $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');


        $sheet->getStyle("C4:H" . intval($i + 4))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:H' . intval($i + 4));
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }
    public function relatorioPagantesCartao(CrmRepository $crmRepository)
    {
        $data = CartaoCredito::with('payer', 'payer.carteirasrel')->get();



        return response()->json($data[2]->payer->carteirasrel, 200);
        foreach ($data as  $value) {

            if (isset($value->payer->id)) {
                foreach ($value->payer->carteirasrel as $carteira) {
                    return $carteira;
                }
            }
        }


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Pagantes Cartão.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Pagantes Cartão Medb');

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:D1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        // $sheet->getColumnDimension('D')->setWidth(12);

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Carteiras');

        $sheet->getStyle("A3:D3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $carteiras = '';
            if (isset($item->payer->carteirasrel)) {
                if (count($item->payer->carteirasrel) >   $tamanhoH) {
                    $tamanhoH = count($item->payer->carteirasrel);

                    $sheet->getColumnDimension('D')->setWidth($tamanhoH * 12);
                }
                foreach ($item->payer->carteirasrel as $carteira) {

                    if ($carteiras != '') {
                        $carteiras = $carteira->nome . ' - ' . $carteiras;
                    }
                    if ($carteiras == '') {
                        $carteiras = $carteira->nome;
                    }
                }

                $sheet->setCellValue('A' . $i, $item->id)
                    ->setCellValue('B' . $i, ' ' . $item->payer->cnpj)
                    ->setCellValue('C' . $i, $item->payer->getName())
                    ->setCellValue('D' . $i,  $carteiras);

                $i++;
            }
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:D' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioEmpresasMesmoSocio(Request $request)
    {

        $cli = Cliente::with('sociosiguais')->withCount('sociosiguais')->get();
        $data  =  $cli->where('sociosiguais_count', '>', 1)->all();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Empresas Com Mesmo Socios .xlsx';

        $sheet->setCellValue('A1', 'Relatorio Empresas Com Mesmo Socios ');

        $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:E1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:E1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(10);



        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Socio');
        $sheet->setCellValue('E3', 'Carteiras');




        $sheet->getStyle("A3:E3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $el) {
            foreach ($el->sociosiguais as $item) {

                // return $item;
                $carteiras = '';

                if ($item->updated_at <= Carbon::now()->subDays($request->quantDay)) {

                    if (count($item->carteirasrel) >   $tamanhoH) {
                        $tamanhoH = count($item->carteirasrel);

                        $sheet->getColumnDimension('E')->setWidth($tamanhoH * 10);
                    }
                    foreach ($item->carteirasrel as $carteira) {

                        if ($carteiras != '') {
                            $carteiras = $carteira->nome . ' - ' . $carteiras;
                        }
                        if ($carteiras == '') {
                            $carteiras = $carteira->nome;
                        }
                    }


                    $sheet->setCellValue('A' . $i, $item->id)
                        ->setCellValue('B' . $i, ' ' . $item->cnpj)
                        ->setCellValue('C' . $i, $item->razao_social)
                        ->setCellValue('D' . $i, $el->nome_completo)
                        ->setCellValue('E' . $i,   $carteiras);



                    $i++;

                    // $sheet->getStyle("A" . intval($i))->getAlignment()->setHorizontal('center');
                }
            }
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');


        $sheet->getPageSetup()->setPrintArea('A1:E' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioGuiasLiberacao(Request $request)
    {

        $data = empresa::with('guia_liberacao')->get();


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Guias Liberação .xlsx';

        $sheet->setCellValue('A1', 'Relatorio  Guias Liberação ');

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:F1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(30);





        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Carteiras');






        $sheet->getStyle("A3:D3")->getFont()->setBold(true);
        $i = 3;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $lib) {
            $i++;
            // return $item;
            $carteiras = '';



            if (count($lib->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($lib->carteirasrel);

                $sheet->getColumnDimension('D')->setWidth($tamanhoH * 10);
            }
            foreach ($lib->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }


            $sheet->setCellValue('A' . $i, $lib->id)
                ->setCellValue('B' . $i, ' ' . $lib->cnpj)
                ->setCellValue('C' . $i, $lib->razao_social)
                ->setCellValue('D' . $i,   $carteiras);
            $i++;

            $sheet->setCellValue('B' . $i, 'Competencia');
            $sheet->setCellValue('C' . $i, 'Data de Envio');
            $sheet->getStyle("B" . $i . ":C" . $i)->getFont()->setBold(true);


            if (isset($lib->guia_liberacao)) {
                foreach ($lib->guia_liberacao as $item) {


                    $i++;
                    $sheet
                        ->setCellValue('B' . $i, $item->competencia)
                        ->setCellValue('C' . $i,   Carbon::parse($item->data_envio)->format('d/m/Y H:m:s'));


                    // $sheet->getStyle("A" . intval($i))->getAlignment()->setHorizontal('center');
                }
            }
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');


        $sheet->getPageSetup()->setPrintArea('A1:F' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioFaturamentoEmpresas(Request $request)
    {

        $data = empresa::with('faturamentos')->get();


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Faturamento .xlsx';

        $sheet->setCellValue('A1', 'Relatorio  Faturamento ');

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:F1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(30);





        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Carteiras');

        $letras = range('A', 'Z');




        $sheet->getStyle("A3:D3")->getFont()->setBold(true);
        $i = 3;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $lib) {
            $i++;
            // return $item;
            $carteiras = '';



            if (count($lib->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($lib->carteirasrel);

                $sheet->getColumnDimension('D')->setWidth($tamanhoH * 10);
            }
            foreach ($lib->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }


            $sheet->setCellValue('A' . $i, $lib->id)
                ->setCellValue('B' . $i, ' ' . $lib->cnpj)
                ->setCellValue('C' . $i, $lib->razao_social)
                ->setCellValue('D' . $i,   $carteiras);
            // $i++;


            // $i++;




            $j = 3;
            if (isset($lib->faturamentos)) {
                // return $lib->faturamentos;


                foreach ($lib->faturamentos as $item) {
                    // $sheet->getStyle("A" . $i-1 . ":F" . $i)->getFont()->setBold(true);

                    $j++;
                    $sheet
                        ->setCellValue($letras[$j] . $i, Carbon::parse($item->mes)->format('d/m/Y'));
                    $sheet->setCellValue($letras[$j] . strval(3), 'competencia');
                    $sheet->getColumnDimension($letras[$j])->setWidth(15);



                    $j++;
                    $sheet->getColumnDimension($letras[$j])->setWidth(15);

                    $sheet->setCellValue($letras[$j] . $i,  $item->faturamento);
                    $sheet->setCellValue($letras[$j] . strval(3), 'Valor');





                    // $sheet->getStyle("A" . intval($i))->getAlignment()->setHorizontal('center');
                }
            }
            // $i++;

        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');


        $sheet->getPageSetup()->setPrintArea('A1:F' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    function convertObjectClass($array, $final_class)
    {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($final_class),
            $final_class,
            strstr(serialize($array), ':')
        ));
    }
    public function relatorioCongeladosHonorarios()
    {
        $empresasSemestral = Empresa::where('status_id', 81)
            ->join('plan_subscriptions', 'plan_subscriptions.payer_id', 'empresas.id')
            ->leftjoin('plans', 'plans.id', 'plan_subscriptions.plan_id')
            // ->whereNull('plan_subscriptions.deleted_at')
            ->select('empresas.created_at', 'empresas.id', 'empresas.status_id', 'empresas.cnpj', 'empresas.razao_social', 'empresas.nome_empresa', 'plans.price as valor', 'plans.id as plans_id', 'plans.updated_at as plan_create')
            ->get()
            ->filter(
                fn ($emps) =>
                $emps->plans_id == 10 &&

                    isset($emps->ultfatura->created_at) ? Carbon::parse($emps->ultfatura->created_at)->addMonths(6)->format('m') <= Carbon::now()->format('m') : null
            );
        $empresasAnual = Empresa::where('status_id', 81)
            ->join('plan_subscriptions', 'plan_subscriptions.payer_id', 'empresas.id')
            ->leftjoin('plans', 'plans.id', 'plan_subscriptions.plan_id')
            // ->whereNull('plan_subscriptions.deleted_at')
            ->select('empresas.created_at', 'empresas.id', 'empresas.status_id', 'empresas.cnpj', 'empresas.razao_social', 'empresas.nome_empresa', 'plans.price as valor', 'plans.id as plans_id', 'plans.updated_at as plan_create')
            ->get()
            ->filter(
                fn ($emps) =>

                $emps->plans_id == 11
            );




        foreach ($empresasSemestral as $item) {
            $data[] = $item;
        }
        // foreach ($empresasAnual as $item2) {
        //     $data[] = $item2;
        // }



        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Empresas Congeladas Cobrança Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Empresas Congeladas Cobrança Medb');

        $sheet->getStyle("A1:E1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:E1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:E1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(60);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

        // $sheet->getColumnDimension('D')->setWidth(17);
        // $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Price');
        $sheet->setCellValue('E3', 'Carteiras');




        $sheet->getStyle("A3:E3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('E')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }


            $sheet->setCellValue('A' . $i, $item->id)
                ->setCellValue('B' . $i, ' ' . $item->cnpj)
                ->setCellValue('C' . $i, $item->nome_empresa == null ? $item->razao_social : $item->nome_empresa)
                ->setCellValue('D' . $i, $item->valor)
                ->setCellValue('E' . $i, $carteiras);

            $i++;
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:E' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioClientesAdm()
    {
        $data = Empresa::get();




        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Empresas Clientes Adm Medb.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Empresas Clientes Adm Medb');

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:J1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(55);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(12);


        // $sheet->getColumnDimension('D')->setWidth(17);
        // $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->setCellValue('A3', 'ID');
        $sheet->setCellValue('B3', 'Cnpj');
        $sheet->setCellValue('C3', 'Empresa');
        $sheet->setCellValue('D3', 'Nome socio');
        $sheet->setCellValue('E3', 'Email');
        $sheet->setCellValue('F3', 'Telefone');
        $sheet->setCellValue('G3', 'Cidade');
        $sheet->setCellValue('H3', 'Estado');
        $sheet->setCellValue('I3', 'Status');
        $sheet->setCellValue('J3', 'Carteiras');


        $status_emp = [100 => 'ativo', '81' => 'Congelada', '71' => 'inativo'];

        $sheet->getStyle("A3:I3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        $tamanhoH = 0;
        // return $data;
        foreach ($data as $item) {
            $carteiras = '';

            if (count($item->carteirasrel) >   $tamanhoH) {
                $tamanhoH = count($item->carteirasrel);

                $sheet->getColumnDimension('I')->setWidth($tamanhoH * 12);
            }
            foreach ($item->carteirasrel as $carteira) {

                if ($carteiras != '') {
                    $carteiras = $carteira->nome . ' - ' . $carteiras;
                }
                if ($carteiras == '') {
                    $carteiras = $carteira->nome;
                }
            }

            if (isset($item->socioAdministrador[0])) {
                $sheet->setCellValue('A' . $i, $item->id)
                    ->setCellValue('B' . $i, ' ' . $item->cnpj)
                    ->setCellValue('C' . $i, $item->nome_empresa == null ? $item->razao_social : $item->nome_empresa)
                    ->setCellValue('D' . $i, $item->socioAdministrador[0]->nome_completo)
                    ->setCellValue('E' . $i, $item->socioAdministrador[0]->email)
                    ->setCellValue('F' . $i, substr(substr($item->contatos()->whatsapp(), 2), 0, -2))
                    ->setCellValue('G' . $i, $item->endereco->cidade ?? '')
                    ->setCellValue('H' . $i, $item->endereco->uf ?? '')
                    ->setCellValue('I' . $i, isset($item->residencia_medica) ? 'Residente' : $this->status[$item->status_id])
                    ->setCellValue('J' . $i, $carteiras);


                $i++;
            }
        }
        $sheet->getStyle("A4:A" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:J' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }


    public function relatorioClientesFat()
    {

        $data = Empresa::with('ultSixMonths')->get();

        $fim = true;
        $janelas = 0;

        // $janelasCarteira =[
        //     'Contábil 1',
        //     'Contábil 1 - Onboarding',
        //     'Contábil 1 - Onboarding 2',

        //     'Contábil 1',
        //     'Contábil 2 - Onboarding',
        //     'Contábil 3 - Onboarding 2',

        //     'Contábil 1',
        //     'Contábil 1 - Onboarding',
        //     'Contábil 1 - Onboarding 2',


        // ];

        $spreadsheet = new Spreadsheet();

        while ($fim == true) {

            $spreadsheet->setActiveSheetIndex($janelas);


            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setTitle('Contábil ' . intval($janelas + 1));
            $sheet->setCellValue('A1', 'Relatorio Clientes Faturas Contábil ' . intval($janelas + 1));

            $filename = 'Relatorio Empresas Clientes Faturas Contábils.xlsx';


            $sheet->getStyle("A1:X1")->getAlignment()->setHorizontal('center');
            $sheet->getStyle("A1:X1")->getFont()->setSize(18);
            $sheet->mergeCells('A1:X1');

            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(17);
            $sheet->getColumnDimension('C')->setWidth(55);
            $sheet->getColumnDimension('D')->setWidth(35);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('Y')->setWidth(15);
            $sheet->getColumnDimension('Y')->setWidth(12);




            $sheet->setCellValue('A3', 'ID');
            $sheet->setCellValue('B3', 'Cnpj');
            $sheet->setCellValue('C3', 'Empresa');
            $sheet->setCellValue('D3', 'Nome socio');
            $sheet->setCellValue('E3', 'tipo');


            $sheet->setCellValue('F3', 'Fatura mes ' . Carbon::now()->subMonths(6)->format('m') + 0);
            $sheet->setCellValue('G3', 'Data Pagamento');
            $sheet->setCellValue('H3', 'Status');

            $sheet->setCellValue('I3', 'Fatura mes ' . Carbon::now()->subMonths(5)->format('m') + 0);
            $sheet->setCellValue('j3', 'Data Pagamento');
            $sheet->setCellValue('K3', 'Status');

            $sheet->setCellValue('L3', 'Fatura mes ' . Carbon::now()->subMonths(4)->format('m') + 0);
            $sheet->setCellValue('M3', 'Data Pagamento');
            $sheet->setCellValue('N3', 'Status');

            $sheet->setCellValue('O3', 'Fatura mes ' . Carbon::now()->subMonths(3)->format('m') + 0);
            $sheet->setCellValue('P3', 'Data Pagamento');
            $sheet->setCellValue('Q3', 'Status');

            $sheet->setCellValue('R3', 'Fatura mes ' . Carbon::now()->subMonths(2)->format('m') + 0);
            $sheet->setCellValue('S3', 'Data Pagamento');
            $sheet->setCellValue('T3', 'Status');

            $sheet->setCellValue('U3', 'Fatura mes ' . Carbon::now()->subMonths(1)->format('m') + 0);
            $sheet->setCellValue('V3', 'Data Pagamento');
            $sheet->setCellValue('W3', 'Status');

            $sheet->setCellValue('X3', 'Carteiras');
            if (intval($janelas + 1) == 4) {
                $sheet->getColumnDimension('Y')->setWidth(14);

                $sheet->setCellValue('Y3', 'Data Congelado');
            }


            $status_emp = [100 => 'ativo', '81' => 'Congelada', '71' => 'inativo'];

            $sheet->getStyle("A3:Z3")->getFont()->setBold(true);
            $i = 4;

            // $carteiras = $request->get('carteira');
            $tamanhoH = 0;
            // return $data;

            $colunasFaturas = [
                Carbon::now()->subMonths(6)->format('m') + 0 => ['l' => "F", 'data' => "G", 'status' => "H"],
                Carbon::now()->subMonths(5)->format('m') + 0 => ['l' => "I", 'data' => "J", 'status' => "K"],
                Carbon::now()->subMonths(4)->format('m') + 0 => ['l' => "L", 'data' => "M", 'status' => "N"],
                Carbon::now()->subMonths(3)->format('m') + 0 => ['l' => "O", 'data' => "P", 'status' => "Q"],
                Carbon::now()->subMonths(2)->format('m') + 0 => ['l' => "R", 'data' => "S", 'status' => "T"],
                Carbon::now()->subMonths(1)->format('m') + 0 => ['l' => "U", 'data' => "V", 'status' => "W"],

            ];
            foreach ($colunasFaturas as $width) {
                $sheet->getColumnDimension($width['l'])->setWidth(12);
                $sheet->getColumnDimension($width['data'])->setWidth(15);
                $sheet->getColumnDimension($width['status'])->setWidth(9);
            }


            foreach ($data as $item) {

                $carteiras = '';


                foreach ($item->carteirasrel as $carteira) {

                    if ($carteiras != '') {
                        $carteiras = $carteira->nome . ' - ' . $carteiras;
                    }
                    if ($carteiras == '') {
                        $carteiras = $carteira->nome;
                    }
                }

                if ($carteiras == 'Contábil ' . intval($janelas + 1)) {
                    if (isset($item->socioAdministrador[0])) {
                        $sheet->setCellValue('A' . $i, $item->id)
                            ->setCellValue('B' . $i, ' ' . $item->cnpj)
                            ->setCellValue('C' . $i, $item->nome_empresa == null ? $item->razao_social : $item->nome_empresa)
                            ->setCellValue('D' . $i, $item->socioAdministrador[0]->nome_completo)
                            ->setCellValue('E' . $i, isset($item->residencia_medica) ? 'Residente' : $this->status[$item->status_id])
                            ->setCellValue('X' . $i, $carteiras);
                        if (intval($janelas + 1) == 4) {

                            $sheet->setCellValue('Y' . $i,   $item->motivoCongelamento[count($item->motivoCongelamento) - 1]->data_congelamento ?? null);
                        }


                        // $j = 0;
                        foreach ($item->ultSixMonths as $ultfat) {
                            $coluna = 0;
                            if (Carbon::parse($ultfat->data_recebimento)->format('m') + 0 <= Carbon::now()->subMonths(1)->format('m') + 0) {
                                $coluna =  Carbon::parse($ultfat->data_recebimento)->format('m') + 0;
                                $sheet->setCellValue($colunasFaturas[$coluna]['l'] . $i, $ultfat->subtotal)
                                    ->setCellValue($colunasFaturas[$coluna]['data'] . $i, Carbon::parse($ultfat->data_recebimento)->format('Y-m-d'))
                                    ->setCellValue($colunasFaturas[$coluna]['status'] . $i, $ultfat->status);

                                // $sheet->setCellValue($colunasFaturas[$j]['l'] . $i, 'Sem Fatura')
                                // ->setCellValue($colunasFaturas[$j]['data'] . $i, 'Sem Recebimento')
                                // ->setCellValue($colunasFaturas[$j]['status'] . $i, 'Sem Fatura');
                                // $j++;
                            }
                        }
                        $i++;
                    }
                }
            }
            $sheet->getStyle("A4:X" . intval($i))->getAlignment()->setHorizontal('center');
            $sheet->getPageSetup()->setPrintArea('A1:X' . intval($i));

            if ('Contábil ' . intval($janelas + 1) == 'Contábil 7') {

                $fim = false;
            } else {
                $janelas++;
                $spreadsheet->createSheet();
            }
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }

    public function relatorioFechamentoMensal(Request $request)
    {
        $params = $request->all();
        return $this->relatorioFechamentoMensalService->execute(Empresa::where('id', $params['empresa_id'])->first(), $params['competencia']);
    }
}
