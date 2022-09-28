<?php


namespace Modules\TaxSimulator\Services;


class IRRFEnum
{
    const RANGE_1 = [
        'revenue' => 1903.98,
        'derive_value' => 0,
        'aliquota' => 0.21
    ];

    const RANGE_2 = [
        'revenue' => 2826.65,
        'derive_value' => 142.80,
        'aliquota' => 0.075
    ];

    const RANGE_3 = [
        'revenue' => 3751.05,
        'derive_value' => 354.80,
        'aliquota' => 0.15
    ];

    const RANGE_4 = [
        'revenue' => 4664.68,
        'derive_value' => 636.13,
        'aliquota' => 0.225
    ];

    const RANGE_5 = [
        'revenue' => 4664.68,
        'derive_value' => 869.36,
        'aliquota' => 0.275
    ];
}
