<?php

namespace Modules\Invoice\Services;


use App\Models\Empresa;
use App\Models\Faturamento;
use App\Services\FaturamentoService;
use App\Services\GuiaService;
use Carbon\Carbon;
use Modules\TaxSimulator\Services\TaxSimulatorService;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

class RelatorioFechamentoMensalService
{
    private Faturamento $faturamento;
    private GuiaService $guiaService;
    private faturamentoService $faturamentoService;
    private array $data;
    private Empresa $empresa;
    private $compentencia;
    private TaxSimulatorService $taxSimulator;


    public $regimes = [
        "SN" => "Simples Nacional",
        "Presumido" => "Lucro Presumido",
        "Isento" => "Isento"
    ];
    public function __construct(Faturamento $faturamento, GuiaService $guiaService, faturamentoService $faturamentoService, TaxSimulatorService $taxSimulator)
    {
        $this->faturamento = $faturamento;
        $this->guiaService = $guiaService;
        $this->faturamentoService = $faturamentoService;
        $this->taxSimulator = $taxSimulator;
    }

    public function execute($empresa, $compentencia)
    {
        $this->empresa = $empresa;
        $this->compentencia = $compentencia;
        $this->consulta1();
        $this->consulta2();

        return $this->consulta3();
    }
    public function consulta1()
    {
        $this->data[0]['cnpj'] = $this->mask($this->empresa->cnpj, '##.###.###/####-##');
        $aux['bruto'] = $this->faturamento->where('empresas_id', $this->empresa->id)->where('mes', $this->compentencia)->first();
        if (isset($aux['bruto']->faturamento)) {
            $this->data[0]['bruto']  = $aux['bruto']->faturamento;
        } else {
            return "Empresa não possui faturamento";
        }
        $aux['imposto'] = 0;

        $guias = $this->guiaService->getGuiasByEmpresa($this->empresa->id, $this->compentencia)->guias;
        foreach ($guias as $guia) {

            if ($guia->tipo != "HONORARIOS") {
                $aux['imposto']  += $guia->valor[strtolower($guia->tipo)];
                $this->data[0][] = ['tipo' => $guia->tipo, 'valor' => $guia->valor[strtolower($guia->tipo)]];
            }
        }
        $this->data[0]['imposto'] = $aux['imposto'];
        $this->data[0]['liquido_pj'] = round($this->data[0]['bruto']  -  $aux['imposto'], 2);
        $this->data[0]['porcetagem_imposto'] =      ($this->data[0]['imposto'] /  $this->data[0]['bruto'] * 100) . '%';
    }


    public function consulta2()
    {
        // return  $this->data[0];
        $arraySimulacao = [
            "expense" => "0",
            "iss" => "3",
            "payroll" => "0",
            "value" =>   $this->data[0]['bruto']
        ];
        $tax = $this->taxSimulator->validateType($arraySimulacao);
        $value = $arraySimulacao['value'] * 12;
        $simulation =  $this->taxSimulator->response($tax, $value);
        $this->data[1]['imposto_pf'] = formata_moeda_db($simulation[10]['clt']);
        $this->data[1]['imposto_pj'] =  formata_moeda_db(min($simulation[10]['anexo-3'], $simulation[10]['anexo-5'], $simulation[10]['sem-reducao']));
        $this->data[1]['imposto_lp'] =  formata_moeda_db(max($simulation[10]['sem-reducao'], $simulation[10]['com-reducao']));
        $this->data[1]['enquadramento'] = $this->regimes[$this->empresa->regime_tributario];

        return $this->data;
    }

    public function consulta3()
    {
        $pt = [ 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro']; 
   
        

        $separacao = null;
        $total['total']=null;
        foreach ($this->empresa->guiasLastSix as $key => $value) {
            if ($value->tipo != "HONORARIOS") {

                foreach ($value->valor as $item) {
                    $separacao[$pt[intval(Carbon::parse($value->data_competencia)->format('m'))-1]][] = ['tipo' => $value->tipo, 'valor' => $item];
                    if(!isset($separacao['total'][$value->tipo]['valor'])){
                        $separacao['total'][$value->tipo] = ['tipo' => $value->tipo ,'valor'=>0 ];

                    }
                    $separacao['total'][$value->tipo]['valor'] +=  $item ;
                }
            }
        }
        // foreach ( $this->empresa->ultSixMonths as $key => $value) {
        //     $separacao[$pt[intval(Carbon::parse($value->data_competencia)->format('m'))-1]][];
        // }


        return $separacao;
    }

    public function mask($val, $mask)
    {

        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) $maskared .= $val[$k++];
            } else {
                if (isset($mask[$i])) $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}
