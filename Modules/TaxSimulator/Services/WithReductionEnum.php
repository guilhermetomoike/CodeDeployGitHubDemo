<?php


namespace Modules\TaxSimulator\Services;


class WithReductionEnum
{
    const PIS = 0.0065;

    const COFINS = 0.03;

    const CSLL = 0.09;
    const CSLL_TAX = 0.12;

    const IRPJ = 0.15;
    const IRPJ_TAX = 0.08;

    const ADDITIONAL = 60000.00;
    const ADDITIONAL_PORCENTAGE = 0.08;
    const ADDITIONAL_TAX = 0.10;
}
