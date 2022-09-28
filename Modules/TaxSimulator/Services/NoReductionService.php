<?php


namespace Modules\TaxSimulator\Services;


class NoReductionService
{
    const SEMESTER_AMOUNT = 4;

    public function withReduction(array $data): array
    {
        $value = $this->valueCalculate($data['value']);

        return [
            'pis' => $this->pisCalculate($value),
            'cofins' => $this->cofinsCalculate($value),
            'iss' => $this->issCalculate($value, $data['iss']),
            'csll' => $this->csllCalculate($value),
            'irpj' => $this->irpjCalculate($value),
            'additional' => $this->additionalCalculate($value),
            'payroll' => $this->payrollCalculate($data['payroll']),
            'prolabore' => $this->prolaboreCalculate()
        ];
    }

    private function valueCalculate(float $value)
    {
        return $value * 3;
    }

    private function pisCalculate(float $value)
    {
        return ($value * NoReductionEnum::PIS) * self::SEMESTER_AMOUNT;
    }

    private function cofinsCalculate(float $value)
    {
        return ($value * NoReductionEnum::COFINS) * self::SEMESTER_AMOUNT;
    }

    private function issCalculate(float $value, float $iss)
    {
        return ($value * $iss) * self::SEMESTER_AMOUNT;
    }

    private function csllCalculate(float $value)
    {
        return (($value * NoReductionEnum::CSLL_TAX) * NoReductionEnum::CSLL) * self::SEMESTER_AMOUNT;
    }

    private function irpjCalculate(float $value)
    {
        return (($value * NoReductionEnum::IRPJ_TAX) * NoReductionEnum::IRPJ) * self::SEMESTER_AMOUNT;
    }

    private function additionalCalculate(float $value)
    {
        $additional = 0;

        $totalAdditional = $value * NoReductionEnum::ADDITIONAL_PORCENTAGE;

        if ($totalAdditional > NoReductionEnum::ADDITIONAL) {
            $additionalExcess = $totalAdditional - NoReductionEnum::ADDITIONAL;

            $additional = $additionalExcess * NoReductionEnum::ADDITIONAL_TAX;
        }

        return $additional * self::SEMESTER_AMOUNT;
    }

    public function payrollCalculate(float $payroll)
    {
        return ($payroll * 0.20) * 12;
    }

    public function prolaboreCalculate()
    {
        return (salario_minimo() * 0.31) * 12;
    }
}
