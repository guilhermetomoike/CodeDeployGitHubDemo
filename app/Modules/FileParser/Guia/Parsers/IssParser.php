<?php

namespace App\Modules\FileParser\Guia\Parsers;

use App\Modules\FileParser\Guia\ParserContract;

class IssParser extends ParserContract
{

    protected $types = ['ISS', 'ISSQN', 'PREFEITURA', 'Prefeitura'];

    public function validateType()
    {
        $foundTypes = [];
        foreach ($this->contentText as $text) {
            foreach ($this->types as $type) {
                $foundType = $this->getType($text, $type);
                if ($foundType) {
                    $foundTypes[] = $foundType;
                }
            }
        }
        $same = array_intersect($this->types, $foundTypes);
        return count($same) > 0;
    }

    protected function output(array $parse)
    {
        return [
            'tipo' => 'ISS',
            'cnpj' => $parse['cnpj'],
            'valor' => $parse['valores'],
            'barcode' => $parse['barcode']
        ];
    }

    protected function setValores(string $text)
    {
        $valores['iss'] = $this->getValor($text);
        return $valores;
    }

    protected function getValor(string $text)
    {
        preg_match_all('/\b(Valor Total: \d*?\.?\d*,\d*)\b/m', $text, $matches);
        $valor = collect($matches)->flatten()->unique()->pop();
        $valor = str_replace('Valor Total: ', '', $valor);
        return formata_moeda_db($valor);
    }

    protected function getBarcode(string $text)
    {


        preg_match_all('/\b(\d{11}-\d\s?){4}\b/m', $text, $matches);
        $barcode = collect($matches)->flatten()->first();
        // $barcode = preg_replace('/[\-\s]/m', ' ', $barcode);
        return $barcode;
    }
}
