<?php


namespace Modules\TaxSimulator\Services;


class TaxSimulatorService
{

    /**
     * @var WithReductionService
     */
    private WithReductionService $withReductionService;
    /**
     * @var NoReductionService
     */
    private NoReductionService $noReductionService;
    /**
     * @var SimpleNationalService
     */
    private SimpleNationalService $simpleService;
    /**
     * @var PhysicalPersonService
     */
    private PhysicalPersonService $personService;
    /**
     * @var CltService
     */
    private CltService $cltService;

    public function __construct(
        WithReductionService $withReductionService,
        NoReductionService $noReductionService,
        SimpleNationalService $simpleService,
        PhysicalPersonService $personService,
        CltService $cltService
    )
    {
        $this->withReductionService = $withReductionService;
        $this->noReductionService = $noReductionService;
        $this->simpleService = $simpleService;
        $this->personService = $personService;
        $this->cltService = $cltService;
    }

    public function validateType(array $data): array
    {
        $data['iss'] = $data['iss'] / 100;

        return [
            "attachment3" => $this->simpleService->validateRangeAttachment3Type($data),
            "attachment5" => $this->simpleService->validateRangeAttachment5Type($data),
            "withReduction" => $this->withReductionService->withReduction($data),
            "noReduction" => $this->noReductionService->withReduction($data),
            "rpa" => $this->personService->rpaCalculate($data),
            "cashbook" => $this->personService->cashBookCalculate($data),
            "clt" => $this->cltService->cltCalculate($data)
        ];
    }

    public function response(array $data, string $value)
    {
        $withReduction = $data['withReduction'];
        $noReduction = $data['noReduction'];
        $attachment3 = $data['attachment3'];
        $attachment5 = $data['attachment5'];
        $clt = $data['clt'];
        $rpa = $data['rpa'];
        $cashbook = $data['cashbook'];
        //  return $clt;
        $revenue = formata_moeda($value);

        //refactor
        $totalWithReduction = $withReduction['iss'] + $withReduction['pis'] +
            $withReduction['cofins'] + $withReduction['irpj'] + $withReduction['csll'] +
            $withReduction['payroll'] + $withReduction['prolabore'];

        $totalNoReduction = $noReduction['iss'] + $noReduction['pis'] +
            $noReduction['cofins'] + $noReduction['irpj'] + $noReduction['csll'] +
            $noReduction['payroll'] + $noReduction['prolabore'];

        $totalAttachment3 = $attachment3['value'] + $attachment3['inss'] + $attachment3['irrf'];

        $totalAttachment5 = $attachment5['value'] + $attachment5['inss'];

        $totalClt = $clt['inss'] + $clt['irrf'];

        $totalRpa = $rpa['iss'] + $rpa['inss'] + $rpa['irrf'];

        $totalCashBook = $cashbook['irrf'] + $cashbook['inss'];


        return [
            [
                'id' => 'Faturamento anual',
                'sem-reducao' => $revenue,
                'com-reducao' => $revenue,
                'anexo-3' => $revenue,
                'anexo-5' => $revenue,
                'clt' => $revenue,
                'rpa' => $revenue,
                'livro-caixa' => $revenue
            ],
            [
                'id' => 'ISS',
                'sem-reducao' => formata_moeda($noReduction['iss']),
                'com-reducao' => formata_moeda($withReduction['iss']),
                'anexo-3' => '-',
                'anexo-5' => '-',
                'clt' => '-',
                'rpa' => formata_moeda($rpa['iss']),
                'livro-caixa' => '-'
            ],
            [
                'id' => 'PIS',
                'sem-reducao' => formata_moeda($noReduction['pis']),
                'com-reducao' => formata_moeda($withReduction['pis']),
                'anexo-3' => '-',
                'anexo-5' => '-',
                'clt' => '-',
                'rpa' => '-',
                'livro-caixa' => '-'
            ],
            [
                'id' => 'Cofins',
                'sem-reducao' => formata_moeda($noReduction['cofins']),
                'com-reducao' => formata_moeda($withReduction['cofins']),
                'anexo-3' => '-',
                'anexo-5' => '-',
                'clt' => '-',
                'rpa' => '-',
                'livro-caixa' => '-'
            ],
            [
                'id' => 'IRPJ',
                'sem-reducao' => formata_moeda($noReduction['irpj']),
                'com-reducao' => formata_moeda($withReduction['irpj']),
                'anexo-3' => '-',
                'anexo-5' => '-',
                'clt' => '-',
                'rpa' => '-',
                'livro-caixa' => '-'
            ],
            [
                'id' => 'CSLL',
                'sem-reducao' => formata_moeda($noReduction['csll']),
                'com-reducao' => formata_moeda($withReduction['csll']),
                'anexo-3' => '-',
                'anexo-5' => '-',
                'clt' => '-',
                'rpa' => '-',
                'livro-caixa' => '-'
            ],
            [
                'id' => 'DAS',
                'sem-reducao' => '-',
                'com-reducao' => '-',
                'anexo-3' => formata_moeda($attachment3['value']),
                'anexo-5' => formata_moeda($attachment5['value']),
                'clt' => '-',
                'rpa' => '-',
                'livro-caixa' => '-'
            ],
            [
                'id' => 'INSS Folha',
                'sem-reducao' => formata_moeda($noReduction['payroll']),
                'com-reducao' => formata_moeda($withReduction['payroll']),
                'anexo-3' => '-',
                'anexo-5' => '-',
                'clt' => '-',
                'rpa' => '-',
                'livro-caixa' => '-'
            ],
            [
                'id' => 'INSS Pró-labore',
                'sem-reducao' => formata_moeda($noReduction['prolabore']),
                'com-reducao' => formata_moeda($withReduction['prolabore']),
                'anexo-3' => formata_moeda($attachment3['inss']),
                'anexo-5' => formata_moeda($attachment5['inss']),
                'clt' => formata_moeda($clt['inss']),
                'rpa' => formata_moeda($rpa['inss']),
                'livro-caixa' => formata_moeda($cashbook['inss'])
            ],
            [
                'id' => 'IRRF Pró-labore',
                'sem-reducao' => '-',
                'com-reducao' => '-',
                'anexo-3' => formata_moeda($attachment3['irrf']),
                'anexo-5' => '-',
                'clt' => formata_moeda($clt['irrf']),
                'rpa' => formata_moeda($rpa['irrf']),
                'livro-caixa' => formata_moeda($cashbook['irrf'])
            ],
            [
                'id' => 'Total de Impostos',
                'sem-reducao' => formata_moeda($totalNoReduction),
                'com-reducao' => formata_moeda($totalWithReduction),
                'anexo-3' => formata_moeda($totalAttachment3),
                'anexo-5' => formata_moeda($totalAttachment5),
                'clt' => formata_moeda($totalClt),
                'rpa' => formata_moeda($totalRpa),
                'livro-caixa' => formata_moeda($totalCashBook)
            ],
            [
                'id' => '% Impostos',
                'sem-reducao' => formata_moeda(($totalNoReduction / $value) * 100),
                'com-reducao' => formata_moeda(($totalWithReduction / $value) * 100),
                'anexo-3' => formata_moeda(($totalAttachment3/ $value) * 100),
                'anexo-5' => formata_moeda(($totalAttachment5 / $value) * 100),
                'clt' => formata_moeda(($totalClt / $value * 100)),
                'rpa' => formata_moeda(($totalRpa / $value) * 100),
                'livro-caixa' => formata_moeda(($totalCashBook/ $value) * 100)
            ],
            [
                'id' => 'Valor Líquido ano',
                'sem-reducao' => formata_moeda($value - $totalNoReduction),
                'com-reducao' => formata_moeda($value - $totalWithReduction),
                'anexo-3' => formata_moeda($value - $totalAttachment3),
                'anexo-5' => formata_moeda($value - $totalAttachment5),
                'clt' => formata_moeda($value - $totalClt),
                'rpa' => formata_moeda($value - $totalRpa),
                'livro-caixa' => formata_moeda($value - $totalCashBook)
            ],
            [
                'id' => 'Valor Líquido mês',
                'sem-reducao' => formata_moeda(($value - $totalNoReduction) / 12),
                'com-reducao' => formata_moeda(($value - $totalWithReduction) / 12),
                'anexo-3' => formata_moeda(($value - $totalAttachment3) / 12),
                'anexo-5' => formata_moeda(($value - $totalAttachment5) / 12),
                'clt' => formata_moeda(($value - $totalClt) / 12),
                'rpa' => formata_moeda(($value - $totalRpa) / 12),
                'livro-caixa' => formata_moeda(($value - $totalCashBook) / 12)
            ]
        ];
    }

}
