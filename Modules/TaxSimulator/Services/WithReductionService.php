<?php


namespace Modules\TaxSimulator\Services;


class WithReductionService
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

    private function valueCalculate($value)
    {
        return $value * 3;
    }

    private function pisCalculate(float $value)
    {
        return ($value * WithReductionEnum::PIS) * self::SEMESTER_AMOUNT;
    }

    private function cofinsCalculate(float $value)
    {
        return ($value * WithReductionEnum::COFINS) * self::SEMESTER_AMOUNT;
    }

    private function issCalculate(float $value, float $iss)
    {
        return ($value * $iss) * self::SEMESTER_AMOUNT;
    }

    private function csllCalculate(float $value)
    {
        return (($value * WithReductionEnum::CSLL_TAX) * WithReductionEnum::CSLL) * self::SEMESTER_AMOUNT;
    }

    private function irpjCalculate(float $value)
    {
        return (($value * WithReductionEnum::IRPJ_TAX) * WithReductionEnum::IRPJ) * self::SEMESTER_AMOUNT;
    }

    private function additionalCalculate(float $value)
    {
        $additional = 0;

        $totalAdditional = $value * WithReductionEnum::ADDITIONAL_PORCENTAGE;

        if ($totalAdditional > WithReductionEnum::ADDITIONAL) {
            $additionalExcess = $totalAdditional - WithReductionEnum::ADDITIONAL;

            $additional = $additionalExcess * WithReductionEnum::ADDITIONAL_TAX;
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
