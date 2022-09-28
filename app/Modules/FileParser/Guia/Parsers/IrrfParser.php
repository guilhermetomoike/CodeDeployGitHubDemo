<?php

namespace App\Modules\FileParser\Guia\Parsers;

use App\Modules\FileParser\Guia\ParserContract;

class IrrfParser extends ParserContract
{
    protected $types = ['IRRF','DARF IR','IR IR'];

    protected function getBarcode(string $text)
    {
        preg_match_all('/\b(\d{11}.-?\d ?){4}\b/m', $text, $matches);
        $barcode = collect($matches)->flatten()->first();
        $barcode = preg_replace('/\b\n/m', ' ', $barcode);
        $barcode = str_replace(" ",'', $barcode);
        $barcode = str_replace("-",'', $barcode);
        return trim($barcode ?? null);
    }
    protected function setValores(string $text)
    {
        $valores = [];
        foreach ($this->types as $type) {
            $currentType = $this->getType($text, $type);
            if ($currentType) {
                $currentType = $this->formatType($currentType);
                $valores[strtolower($currentType)] = $this->getValor($text);
            }
        }
        return $valores;
    }
    
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
        $type = str_replace('/DARF IR/IR IR ', '', $type);

        return 'IRRF';
    }
}
