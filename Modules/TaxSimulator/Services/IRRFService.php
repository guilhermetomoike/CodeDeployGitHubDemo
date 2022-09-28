<?php


namespace Modules\TaxSimulator\Services;


class IRRFService
{
    public function irpfType(float $prolabore, float $inss)
    {
        switch ($prolabore) {
            case $prolabore <= IRRFEnum::RANGE_1['revenue']:
                return $this->irpfCalculate(IRRFEnum::RANGE_1, $prolabore, $inss);

            case $prolabore <= IRRFEnum::RANGE_2['revenue']:
                return $this->irpfCalculate(IRRFEnum::RANGE_2, $prolabore, $inss);

            case $prolabore <= IRRFEnum::RANGE_3['revenue']:
                return $this->irpfCalculate(IRRFEnum::RANGE_3, $prolabore, $inss);

            case $prolabore <= IRRFEnum::RANGE_4['revenue']:
                return $this->irpfCalculate(IRRFEnum::RANGE_4, $prolabore, $inss);
        }

        return $this->irpfCalculate(IRRFEnum::RANGE_5, $prolabore, $inss);
    }

    public function irpfCalculate(array $data, float $prolabore, $inss)
    {
        if ($prolabore < IRRFEnum::RANGE_1['revenue']) {
            return 0;
        }

        $irrf = (($prolabore - $inss) * $data['aliquota']) - $data['derive_value'];

        return $irrf * 12;
    }
}
