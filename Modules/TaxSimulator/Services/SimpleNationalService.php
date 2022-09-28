<?php


namespace Modules\TaxSimulator\Services;


class SimpleNationalService
{
    const QUANTITY_MONTHS_IN_YEAR = 12;
    const INSS_TAX = 0.11;

    /**
     * @var IRRFService
     */
    private IRRFService $irrfService;

    public function __construct(IRRFService $IRRFService)
    {
        $this->irrfService = $IRRFService;
    }
    public function validateRangeAttachment3Type(array $data)
    {
        $value = $this->valueCalculate($data['value']);
        $payroll = $this->payrollCalculate($data['payroll']);

        switch ($value) {
            case $value <= SimpleNationalAttachment3Enum::RANGE_1['revenue']:
                return $this->calculateTax(SimpleNationalAttachment3Enum::RANGE_1, $value, $payroll);

            case $value <= SimpleNationalAttachment3Enum::RANGE_2['revenue']:
                return $this->calculateTax(SimpleNationalAttachment3Enum::RANGE_2, $value, $payroll);

            case $value <= SimpleNationalAttachment3Enum::RANGE_3['revenue']:
                return $this->calculateTax(SimpleNationalAttachment3Enum::RANGE_3, $value, $payroll);

            case $value <= SimpleNationalAttachment3Enum::RANGE_4['revenue']:
                return $this->calculateTax(SimpleNationalAttachment3Enum::RANGE_4, $value, $payroll);

            case $value <= SimpleNationalAttachment3Enum::RANGE_5['revenue']:
                return $this->calculateTax(SimpleNationalAttachment3Enum::RANGE_5, $value, $payroll);

            case $value <= SimpleNationalAttachment3Enum::RANGE_6['revenue']:
                return $this->calculateTax(SimpleNationalAttachment3Enum::RANGE_6, $value, $payroll);
        }

        return [];
    }

    public function validateRangeAttachment5Type(array $data)
    {
        $value = $this->valueCalculate($data['value']);
        $payroll = $this->payrollCalculate($data['payroll']);

        switch ($value) {
            case $value <= SimpleNationalAttachment5Enum::RANGE_1['revenue']:
                return $this->calculateTax(SimpleNationalAttachment5Enum::RANGE_1, $value, $payroll);

            case $value <= SimpleNationalAttachment5Enum::RANGE_2['revenue']:
                return $this->calculateTax(SimpleNationalAttachment5Enum::RANGE_2, $value, $payroll);

            case $value <= SimpleNationalAttachment5Enum::RANGE_3['revenue']:
                return $this->calculateTax(SimpleNationalAttachment5Enum::RANGE_3, $value, $payroll);

            case $value <= SimpleNationalAttachment5Enum::RANGE_4['revenue']:
                return $this->calculateTax(SimpleNationalAttachment5Enum::RANGE_4, $value, $payroll);

            case $value <= SimpleNationalAttachment5Enum::RANGE_5['revenue']:
                return $this->calculateTax(SimpleNationalAttachment5Enum::RANGE_5, $value, $payroll);

            case $value <= SimpleNationalAttachment5Enum::RANGE_6['revenue']:
                return $this->calculateTax(SimpleNationalAttachment5Enum::RANGE_6, $value, $payroll);
        }

        return [];
    }

    private function valueCalculate(float $value)
    {
        return $value * self::QUANTITY_MONTHS_IN_YEAR;
    }

    private function payrollCalculate(float $payroll)
    {
        return $payroll * self::QUANTITY_MONTHS_IN_YEAR;
    }

    private function calculateTax(array $data, float $value, float $payroll): array
    {
        $deriveValue = ($value * $data['aliquota']) - $data['derive_value'];

        $aliquota = ($deriveValue / $value);

        $prolabore = $this->prolaboreCalculate($data['slug'], $value, $payroll);
        $inss = $this->inssCalculate($data['slug'], $value, $payroll);

        return [
            'range' => $data['range'],
            'aliquota' => $aliquota * 100,
            'derive_value' => $data['derive_value'],
            'value' =>$value * $aliquota,
            'prolabore' => $prolabore,
            'inss' => $inss,
            'irrf' => $this->irrfService->irpfType($prolabore / 12, $inss / 12)
        ];
    }

    public function prolaboreCalculate(string $type, float $value, float $payroll)
    {
        if ($type == 'attachment-5') {
            return $this->prolaboreattachment5Calculate();
        }

        return $this->prolaboreattachment3Calculate($value, $payroll);
    }

    public function inssCalculate(string $type, float $value, float $payroll)
    {
        if ($type == 'attachment-5') {
            return $this->inssAttachment5Calculate();
        }

        return $this->inssAttachment3Calculate($value, $payroll);
    }

    public function prolaboreattachment5Calculate()
    {
        return salario_minimo() * self::QUANTITY_MONTHS_IN_YEAR;
    }

    public function inssAttachment5Calculate()
    {
        return $this->prolaboreattachment5Calculate() * self::INSS_TAX;
    }

    public function prolaboreattachment3Calculate(float $value, float $payroll)
    {
        return ($value * 0.28) - $payroll;
    }

    public function inssAttachment3Calculate(float $value, float $payroll)
    {
        if (($this->prolaboreattachment3Calculate($value, $payroll) / 12) > SimpleNationalAttachment3Enum::ROOF_INSS) {
            return (SimpleNationalAttachment3Enum::ROOF_INSS * self::QUANTITY_MONTHS_IN_YEAR) * self::INSS_TAX;
        }

        return $this->prolaboreattachment3Calculate($value, $payroll) * self::INSS_TAX;
    }
}
