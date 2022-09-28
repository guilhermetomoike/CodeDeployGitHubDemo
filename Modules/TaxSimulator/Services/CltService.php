<?php


namespace Modules\TaxSimulator\Services;


class CltService
{
    /**
     * @var PhysicalPersonService
     */
    private PhysicalPersonService $personService;

    public function __construct(PhysicalPersonService $personService)
    {
        $this->personService = $personService;
    }

    public function cltCalculate(array $data)
    {
        $inss = $this->payrollCalculate($data['value']);
        if ($data['value']  > 1212) {
            $irrfData = $this->personService->irpfType($data['value']);
            $irrf = $this->personService->irpfCalculate($irrfData, $data['value'], $inss);
        }else{
            $irrf =0;
        }

        return [
            'inss' => $inss * 12,
            'irrf' => $irrf * 12
        ];
    }

    public function payrollCalculate(float $value)
    {
        $clt = 0;
        $range = null;

        if ($value <= CltEnum::RANGE_1['end_wage']) {
            $clt += $value *  CltEnum::RANGE_1['aliquata'];
            $range = CltEnum::RANGE_1['range'];
        }else{


        if ($value >= CltEnum::RANGE_1['end_wage']) {
            $clt += $this->calculateRangeWage(CltEnum::RANGE_1);
            $range = CltEnum::RANGE_1['range'];
        }

        if ($value >= CltEnum::RANGE_2['end_wage']) {
            $clt += $this->calculateRangeWage(CltEnum::RANGE_2);
            $range = CltEnum::RANGE_2['range'];
        }

        if ($value >= CltEnum::RANGE_3['end_wage']) {
            $clt += $this->calculateRangeWage(CltEnum::RANGE_3);
            $range = CltEnum::RANGE_3['range'];
        }
        
 

        $clt += $this->calculateDiff($value, $this->validateEndRange($range));
   }
        
        return $clt;
    }

    public function validateEndRange($range)
    {
        switch ($range) {
            case 1:
                return CltEnum::RANGE_2;
            case 2:
                return CltEnum::RANGE_3;
        }

        return CltEnum::RANGE_4;
    }

    public function calculateRangeWage(array $data)
    {
        $dif = $data['end_wage'] - $data['initial_wage'];

        return $dif * $data['aliquata'];
    }

    

    public function calculateDiff(float $value, array $data)
    {
        if ($value >= $data['end_wage'] && $data['range']) {
            return ($data['end_wage'] - $data['initial_wage']) * $data['aliquata'];
        }

        return ($value - $data['initial_wage']) * $data['aliquata'];
    }
}
