<?php


namespace Modules\TaxSimulator\Services;


class CltEnum
{
    const RANGE_1 = [
        'range' => 1,
        'initial_wage' => 0,
        'end_wage' => 1212,
        'aliquata' => 0.075
    ];

    const RANGE_2 = [
        'range' => 2,
        'initial_wage' => 1212.01,
        'end_wage' => 2427.35,
        'aliquata' => 0.09
    ];

    const RANGE_3 = [
        'range' => 3,
        'initial_wage' => 2427.36,
        'end_wage' => 3641.04,
        'aliquata' => 0.12
    ];

    const RANGE_4 = [
        'range' => 4,
        'initial_wage' => 3641.05,
        'end_wage' => 7087.22,
        'aliquata' => 0.14
    ];
}
