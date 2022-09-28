<?php

namespace App\Modules\FileParser\Guia\Parsers;

use App\Modules\FileParser\Guia\ParserContract;
use Illuminate\Support\Facades\Log;

class DasParser extends ParserContract
{

    protected $types = ["Documento de Arrecada.*o[\n\s]do Simples Nacional"];

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

    protected function getValor(string $text)
    {
        preg_match_all('/\b(Valor: \d*?\.?\d*,\d*)\b/m', $text, $matches);
        $valor = collect($matches)->flatten()->unique()->pop();
        $valor = str_replace('Valor: ', '', $valor);
        return formata_moeda_db($valor);
    }

    private function formatType(string $type)
    {
        $type = str_replace('ocumento de ', '', $type);
        $type = str_replace('rrecadacao do ', '', $type);
        $type = str_replace('imples Nacional', '', $type);
        return 'DAS';
    }

    protected function getBarcode(string $text)
    {
        preg_match_all('/\b(\d{11}.?\d\s){4}\b/m', $text, $matches);
        $barcode = collect($matches)->flatten()->first();
        $barcode = preg_replace('/\b\n/m', ' ', $barcode);
        return trim($barcode ?? null);
    }
}
