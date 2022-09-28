<?php

namespace App\Modules\FileParser\Guia;

use App\Modules\FileParser\Guia\Parsers\CofinsParser;
use App\Modules\FileParser\Guia\Parsers\CsllParser;
use App\Modules\FileParser\Guia\Parsers\DasParser;
use App\Modules\FileParser\Guia\Parsers\FgtsParser;
use App\Modules\FileParser\Guia\Parsers\HoleriteParser;
use App\Modules\FileParser\Guia\Parsers\InssParser;
use App\Modules\FileParser\Guia\Parsers\IrpjCsllParser;
use App\Modules\FileParser\Guia\Parsers\IrpjParser;
use App\Modules\FileParser\Guia\Parsers\IrrfParser;
use App\Modules\FileParser\Guia\Parsers\IssParser;
use App\Modules\FileParser\Guia\Parsers\PisCofinsParser;
use App\Modules\FileParser\Guia\Parsers\PisParser;
use ReflectionClass;

class ParserEnum
{
    public const HOLERITE = HoleriteParser::class;
    public const DAS = DasParser::class;
    public const IRPJCSLL = IrpjCsllParser::class;
    public const IRPJ = IrpjParser::class;
    public const CSLL = CsllParser::class;
    public const PISCOFINS = PisCofinsParser::class;
    public const PIS = PisParser::class;
    public const COFINS = CofinsParser::class;
    public const INSS = InssParser::class;
    public const IRRF = IrrfParser::class;
    public const FGTS = FgtsParser::class;
    public const ISS = IssParser::class;

    public static function getValues() {
        $class = new ReflectionClass(__CLASS__);
        return $class->getConstants();
    }
}
