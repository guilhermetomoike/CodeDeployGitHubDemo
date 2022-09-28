<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Arquivo;
use App\Models\CarteiraEmpresa;
use App\Models\Empresa;
use App\Services\Chart\DatasetBuilders\CashFlowForecastService;
use App\Services\Chart\DatasetBuilders\CashFlowStatsService;
use App\Services\Chart\DatasetBuilders\CompaniesOpeningChartService;
use App\Services\Chart\DatasetBuilders\CompaniesContractStarts;
use App\Services\Chart\DatasetBuilders\CompaniesQuantityStarts;
use App\Services\Chart\DatasetBuilders\CountAlvarasStats;
use App\Services\Chart\DatasetBuilders\CountNewCompaniesStats;
use App\Services\Chart\DatasetBuilders\IrpfStats;
use App\Services\Chart\DatasetBuilders\MonthlyPaymentStatsService;
use App\Services\Chart\DatasetBuilders\PaymentDefaulterService;
use App\Services\Chart\DatasetBuilders\PendingContractsList;
use App\Services\Chart\DatasetBuilders\PendingRegisterCompletionList;
use App\Services\Chart\DatasetBuilders\SalesStatsService;
use App\Services\Chart\DatasetBuilders\TaxesStatsService;
use App\Services\Chart\DatasetBuilders\TimeByStepInOpeningService;
use App\Services\Chart\DatasetChartService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Irpf\Services\IrpfService;
use Svg\Tag\Group;

class DashboardController
{
    private DatasetChartService $datasetChartService;
    private IrpfService $irpfService;

    public function __construct(DatasetChartService $datasetChartService, IrpfService $irpfService)
    {
        $this->datasetChartService = $datasetChartService;
        $this->irpfService = $irpfService;
    }

    public function companiesQuantityStats(): JsonResponse
    {
        $data = $this->datasetChartService->getQualifiedDataset(new CompaniesQuantityStarts);
        return new JsonResponse($data);
    }

    public function companiesContractStats(): JsonResponse
    {
        $data = $this->datasetChartService->getQualifiedDataset(new CompaniesContractStarts);
        return new JsonResponse($data);
    }

    public function salesQuantityByMonth(): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new SalesStatsService);
        return new JsonResponse($dataSet);
    }

    public function companiesOpeningStats(Request $request): JsonResponse
    {
        if (isset($request->data)) {
            $dataSet = $this->companiesOpeningStatsHistory($request->data, $request->carteira_id);
        } else {
            $dataSet = $this->datasetChartService->getQualifiedDataset(new CompaniesOpeningChartService, $request->all());
        }
        return new JsonResponse($dataSet);
    }

    public function monthlyTaxesStats(Request $request): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new TaxesStatsService, $request->all());
        return new JsonResponse($dataSet);
    }

    public function cashFlow(): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new CashFlowStatsService);
        return new JsonResponse($dataSet);
    }

    public function cashFlowForecast(): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new CashFlowForecastService);
        return new JsonResponse($dataSet);
    }

    public function monthlyPaymentsStats(Request $request): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new MonthlyPaymentStatsService, $request->all());
        return new JsonResponse($dataSet);
    }

    public function paymentDefaulter(): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new PaymentDefaulterService);
        return new JsonResponse($dataSet);
    }

    public function contractsAwaitingSignature(): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new PendingContractsList);
        return new JsonResponse($dataSet);
    }

    public function registerAwaiting(): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new PendingRegisterCompletionList);
        return new JsonResponse($dataSet);
    }

    public function timePerStepInOpeningCompanies(Request $request): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(
            new TimeByStepInOpeningService,
            $request->all()
        );
        return new JsonResponse($dataSet);
    }

    public function quantityAlvaras($id): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new CountAlvarasStats, ['carteira_id' => $id]);
        return new JsonResponse($dataSet);
    }
    public function quantityCnpj($id)
    {

        $cnpj =  Arquivo::query()

            ->where('model_type', 'empresa')
            ->where('updated_at', '>=', Carbon::now()->setDay(1)->format('Y-m-d'))
            ->where('updated_at', '<=', Carbon::now()->setDay(30)->format('Y-m-d'))
            ->where('nome', 'cartao_cnpj')
            ->where(function ($query)  use ($id) {
                if ($id != 0) {
                    $query->where('carteira_empresa.carteira_id', $id);
                }
            })

            ->leftjoin('carteira_empresa', 'carteira_empresa.empresa_id', 'arquivos.model_id')
            ->select('arquivos.id', 'arquivos.updated_at', 'carteira_empresa.carteira_id')
            ->get();


        $thisWeek = $cnpj->where('updated_at', '>=', today()->floorWeek()->toDateTimeString())->count();
        $thisMonth = $cnpj->count();
        $dataSet = [
            'in_week' => $thisWeek,
            'in_month' => $thisMonth
        ];


        return new JsonResponse($dataSet);
    }

    public function quantityNewCompanies(): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new CountNewCompaniesStats);
        return new JsonResponse($dataSet);
    }

    public function irpfStats(): JsonResponse
    {
        $dataSet = $this->datasetChartService->getQualifiedDataset(new IrpfStats($this->irpfService));
        return new JsonResponse($dataSet);
    }

    public function quantityCompaniesForCarteira()
    {
        $result =  Empresa::query()
            // ->where('empresas.deleted_at',null)
            ->whereNotIn('empresas.status_id', [70, 71])
            ->join('carteira_empresa', 'carteira_empresa.empresa_id', 'empresas.id')
            ->join('carteiras', 'carteiras.id', 'carteira_empresa.carteira_id')
            ->where('carteiras.setor', '<>', 'rh')
            ->select(DB::raw('count(*) as count, carteira_empresa.carteira_id,carteiras.nome as label'))
            ->groupBy('carteira_empresa.carteira_id')
            ->orderBY('carteiras.nome')
            ->get();

        foreach ($result as $item) {

            $data[] = $item->count;


            $label[] = $item->label;
        }

        return $dataSet = [
            "label" => [$label[7], $label[8], $label[0], $label[1], $label[2], $label[3], $label[4], $label[5], $label[6]],
            "datasets" => [
                [
                    "backgroundColor" => 'rgba(75, 10, 192, 0.5)',
                    "data" => [$data[7], $data[8], $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]],
                ]
            ]
        ];
        return new JsonResponse($dataSet);
    }

    public function companiesOpeningStatsHistory($date, $carteira_id)
    {
        // return Carbon::parse($data)->format('Y-m-d');

        $statusIdNeeded = [9, 3, 4, 5, 6, 7, 100];
        $label = [
            "Pré-cadastro",
            // "Aguardando assinatura",
            "Aguardando certificado",
            "Aguardando CNPJ",
            "Aguardando alvará",
            "Aguardando acesso",
            "Aguardando simples",
            "Finalizado ativo"

        ];
        $result =     ActivityLog::query()
            ->where('activity_log.created_at', '>=', Carbon::parse($date[0])->format('Y-m-d'))
            ->where('activity_log.created_at', '<=', Carbon::parse($date[1])->format('Y-m-d'))

            ->where('activity_log.subject_type', 'empresa')
            ->where('activity_log.properties', 'like', '%status_id%')
            ->where('activity_log.description', 'updated')
            ->join('carteira_empresa', 'carteira_empresa.empresa_id', 'activity_log.subject_id')

            ->where(function ($query)  use ($carteira_id) {
                if ($carteira_id != 0) {
                    $query->where('carteira_empresa.carteira_id', $carteira_id);
                }
            })
            ->select('activity_log.id', 'activity_log.properties','activity_log.created_at','activity_log.subject_id')
            ->get();
        $data = [];
  
        foreach ($result as $item) {
            if (!isset($data[$item->subject_id])) {
                $data[$item->subject_id] = ['id' => $item->subject_id, 'status' => json_decode($item->properties)->attributes->status_id];
            }
            // $data[]= $item->count;


            // $label[] = $item->label;
        }


        $empresas = [];
        $count = [9 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 100 => 0];
        foreach ($data as $emp) {
            if (in_array($emp['status'], $statusIdNeeded)) {
                $count[$emp['status']] =  1 + $count[$emp['status']];
            }
        }

        return [
            "label" => $label,
            "datasets" => [
                [
                    "backgroundColor" => 'rgba(75, 192, 192, 0.5)',
                    "data" => array_values($count)
                ]
            ]
        ];
        // return new JsonResponse($dataSet);

    }
}
