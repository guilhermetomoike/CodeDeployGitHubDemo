<?php


namespace Modules\TaxSimulator\Services;


class PhysicalPersonService
{
    const INSS_TAX = 0.11;
    const INSS_TAX_CASHBOOK = 0.20;

    /**
     * @var IRRFService
     */
    private IRRFService $irrf;

    public function __construct(IRRFService $irrf)
    {
        $this->irrf = $irrf;
    }

    public function rpaCalculate(array $data)
    {
        $inss = $this->inssCalculate($data['value'], self::INSS_TAX);
        $iss = $this->issCalculate($data['value'], $data['iss']);
        $irrfData = $this->irpfType($data['value']);
        $irrf = $this->irpfCalculate($irrfData, $data['value'], $inss);
        return [
            "iss" => $iss * 12,
            "inss" => $inss * 12,
            "irrf" => $irrf * 12
        ];
    }

    public function cashBookCalculate(array $data)
    {
        $inss = $this->inssCalculate($data['value'], self::INSS_TAX_CASHBOOK);
        $profit = $this->profitCalculate($data['value'], $data['expense'], 0);
        $irrfData = $this->irpfType($profit);
        $irrf = $this->irrfCashBookCalculate($irrfData, $profit);

        return [
            "inss" => $inss * 12,
            "irrf" => $irrf * 12
        ];

    }

    public function irrfCashBookCalculate(array $data, $profit)
    {
        return ($profit * $data['aliquota'] - $data['derive_value']);
    }

    public function profitCalculate(float $value, float $expense, float $inss)
    {
        return ($value - $expense) - $inss;
    }

    public function inssCalculate(float $value, float $inss)
    {
        if ($value > SimpleNationalAttachment3Enum::ROOF_INSS) {
            return SimpleNationalAttachment3Enum::ROOF_INSS * $inss;
        }

        return $value * $inss;
    }

    public function irpfType(float $value)
    {
        switch ($value) {
            case $value <= IRRFEnum::RANGE_1['revenue']:
                return IRRFEnum::RANGE_1;

            case $value <= IRRFEnum::RANGE_2['revenue']:
                return IRRFEnum::RANGE_2;

            case $value <= IRRFEnum::RANGE_3['revenue']:
                return IRRFEnum::RANGE_3;

            case $value <= IRRFEnum::RANGE_4['revenue']:
                return IRRFEnum::RANGE_4;
        }
        return IRRFEnum::RANGE_5;
    }

    public function irpfCalculate(array $data, float $value, float $inss)
    {
        return (($value - $inss) * $data['aliquota']) - $data['derive_value'];
    }

    public function issCalculate(float $value, float $iss)
    {
        return $value * $iss;
    }
}
