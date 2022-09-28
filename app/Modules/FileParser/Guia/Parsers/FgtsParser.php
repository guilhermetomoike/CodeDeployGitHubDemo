<?php

namespace App\Modules\FileParser\Guia\Parsers;

use App\Modules\FileParser\Guia\ParserContract;

class FgtsParser extends ParserContract
{

    protected $types = ['FGTS'];

    protected function getValor(string $text)
    {
        preg_match_all('/\b(TOTAL A RECOLHER \d*?\.?\d*,\d*)\b/m', $text, $matches);
        $valor = collect($matches)->flatten()->unique()->pop();
        preg_match('/\b(\d*?\.?\d*,\d*)\b/m', $valor, $valor);
        return formata_moeda_db($valor[0] ?? 0);
    }
}
