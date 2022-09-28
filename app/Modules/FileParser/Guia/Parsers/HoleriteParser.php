<?php

namespace App\Modules\FileParser\Guia\Parsers;

use App\Modules\FileParser\Guia\ParserContract;

class HoleriteParser extends ParserContract
{

    protected $customType = 'HOLERITE';
    protected $types = ['Recibo de Pagamento de Salario'];

    protected function output(array $parse)
    {
        return [
            'tipo' => $this->customType,
            'cnpj' => $parse['cnpj'],
            'valor' => null,
        ];
    }

    protected function setValores(string $text)
    {
        return [];
    }
}
