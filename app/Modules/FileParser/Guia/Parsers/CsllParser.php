<?php

namespace App\Modules\FileParser\Guia\Parsers;

use App\Modules\FileParser\Guia\ParserContract;

class CsllParser extends ParserContract
{

    protected $types = ['CSLL','CSOC'];
 
    protected function output(array $parse)
    {
        $type = implode("/", $this->types);
        $type = $this->formatType($type);
        return [
            'tipo' => $type,
            'cnpj' => $parse['cnpj'],
            'valor' => $parse['valores'],
            'barcode' => $parse['barcode'],
        ];
    }

    public function validateType()
    {
        foreach ($this->contentText as $text) {
            foreach ($this->types as $type) {
                $foundType = $this->getType($text, $type);
                if ($foundType && preg_match("/\b$type\b/m", $foundType)) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function formatType(string $type)
    {
        $type = str_replace('/CSOC', '', $type);

        return $type;
    }


    
}
