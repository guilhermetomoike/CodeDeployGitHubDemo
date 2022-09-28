<?php

namespace App\Modules\FileParser\Guia;

abstract class ParserContract
{
    protected $contentText = [];
    protected $types = [];

    public function __construct(array $contentText)
    {
        $this->contentText = $contentText;
    }

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

        return $this->types === $foundTypes;
    }

    public function parse()
    {
        $parse = [
            'cnpj' => [],
            'valores' => [],
        ];

        foreach ($this->contentText as $text) {
            $parse['cnpj'] = $this->getCnpj($text);
            $parse['valores'] = array_merge($parse['valores'], $this->setValores($text));
            $parse['barcode'] = $this->getBarcode($text);
        }

        return $this->output($parse);
    }

    protected function output(array $parse)
    {
        return [
            'tipo' => implode("/", $this->types),
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
                $valores[strtolower($currentType)] = $this->getValor($text);
            }
        }
        return $valores;
    }

    protected function getType(string $text, string $type)
    {
        preg_match_all("/\b$type\b/m", $text, $matches);
        return collect($matches)->flatten()->unique()->pop();
    }

    protected function getCnpj(string $text)
    {
        preg_match_all('/\b ?\d{1} ?\d{1}\. ?\d{1} ?\d{1} ?\d{1}\. ?\d{1} ?\d{1} ?\d{1} ?\/\d{4}\-\d{2}\b|\b\d{2,3}\.\d{3}\. \d{3}\/\d{4}\-\d{2}\b/m', $text, $matches);
        return collect($matches)
            ->flatten()
            ->unique()
            ->map(function ($cnpj) {
                return formata_cnpj_bd(str_replace(" ", "",$cnpj));
            });
    }

    protected function getValor(string $text)
    {
        preg_match_all('/\b\d*?\.?\d*,\d*\b/m', $text, $matches);
        $valor = collect($matches)->flatten()->unique();
        return $valor->transform(function ($item) {
            return formata_moeda_db($item);
        })
            ->sort()
            ->pop();
    }

    protected function getBarcode(string $text)
    {
        preg_match_all('/\b(\d{12}\s){4}\b/m', $text, $matches);
        $barcode = collect($matches)->flatten()->first();
        return trim($barcode ?? null);
    }
}
