<?php


namespace Modules\TaxSimulator\Services;


class SimpleNationalAttachment3Enum
{
    const RANGE_1 = [
        'slug' => 'attachment-3',
        'range' => '1a Faixa',
        'revenue' => 180000,
        'derive_value' => 0,
        'aliquota' => 0.06
    ];

    const RANGE_2 = [
        'slug' => 'attachment-3',
        'range' => '2a Faixa',
        'revenue' => 360000,
        'derive_value' => 9360,
        'aliquota' => 0.112
    ];

    const RANGE_3 = [
        'slug' => 'attachment-3',
        'range' => '3a Faixa',
        'revenue' => 720000,
        'derive_value' => 17640,
        'aliquota' => 0.135
    ];

    const RANGE_4 = [
        'slug' => 'attachment-3',
        'range' => '4a Faixa',
        'revenue' => 1800000,
        'derive_value' => 35640,
        'aliquota' => 0.16
    ];

    const RANGE_5 = [
        'slug' => 'attachment-3',
        'range' => '5a Faixa',
        'revenue' => 3600000,
        'derive_value' => 125640,
        'aliquota' => 0.21
    ];

    const RANGE_6 = [
        'slug' => 'attachment-3',
        'range' => '6a Faixa',
        'revenue' => 4800000,
        'derive_value' => 648000,
        'aliquota' => 0.33
    ];

    CONST ROOF_INSS = 7087.22;
}
