<?php

namespace App\Modules\FileParser\Receita;

use App\Models\Empresa;

class ReceitaParser
{
    protected $contentText = [];

    public function __construct(array $contentText)
    {
        $this->contentText = $contentText;
    }

    public function parse()
    {
        return [
            'cnpj' => $this->getCnpj(),
            'rpa' => $this->getRpa(),
            'pa' => $this->getPa(),
            'fatorR' => $this->getFatorR(),
            'cpp' => $this->getCpp(),
        ];
    }

    public function validateType()
    {
        foreach ($this->contentText as $text) {
            $found = preg_match_all("/\bExtrato do Simples Nacional\b/m", $text);
            return $found > 0;
        }
        return false;
    }

    private function getCnpj()
    {
        $cnpj = '';
        foreach ($this->contentText as $text) {
            $found = preg_match_all('/\bCNPJ Estabelecimento: \d{2,3}\.\d{3}\.\d{3}\/\d{4}\-\d{2}\b/m', $text, $matches);
            if ($found > 0) {
                $cnpj = collect($matches)->flatten()->unique()->pop();
            }
        }
        $cnpj = str_replace('CNPJ Estabelecimento: ', '', $cnpj);

        $empresa =Empresa::where('cnpj',$cnpj)->first();

        if (!isset($empresa->id)) {
            $cnpj = '';
            $cnpj2 = '';

            foreach ($this->contentText as $text) {
                $found = preg_match_all('/\bCNPJ B.*sico: \d{2,3}\.\d{3}\.\d{3}\b/m', $text, $matches);
                if ($found > 0) {
                    $cnpj = collect($matches)->flatten()->unique()->pop();
                }
                $found2 = preg_match_all('/\b\/\d{4}\-\d{2}\b/m', $text, $matches);
                if ($found2 > 0) {
                    $cnpj2 = collect($matches)->flatten()->unique()->pop();
                }
            }
                // }
                $cnpj = str_replace('CNPJ Basico: ', '', $cnpj);
                $cnpj = str_replace('CNPJ Básico: ', '', $cnpj);

                return formata_cnpj_bd($cnpj . '' . $cnpj2);
          
        }
        return formata_cnpj_bd($cnpj);
    }

    private function getRpa()
    {
        $rpa = '';
        foreach ($this->contentText as $text) {
            $found = preg_match_all('/\b \(RPA\) - Compet.*ncia \d*?\.?\d*,\d*\b/m', $text, $matches);
            if ($found > 0) {
                $rpa = collect($matches)->flatten()->unique()->pop();
            }
        }
        preg_match('/\d*?\.?\d*,\d*\b/', $rpa, $value);
        return formata_moeda_db($value[0] ?? 0);
    }

    private function getPa()
    {
        $pa = '';
        foreach ($this->contentText as $text) {
            $found = preg_match_all('/\bPer.*do de Apura.*o \(PA\) : [0-9]{2}\/[0-9]{4}\b/m', $text, $matches);
            if ($found > 0) {
                $pa = collect($matches)->flatten()->unique()->pop();
            }
        }
        preg_match('/[0-9]{2}\/[0-9]{4}\b/', $pa, $pa);
        $pa = str_replace('/', '-', $pa[0] ?? null);
        return $pa;
    }

    private function getFatorR()
    {
        $fatorR = '';
        foreach ($this->contentText as $text) {
            $found = preg_match_all('/\b(Fator r( [=E-] | )\d*?\.?\d*,\d*)\b/m', $text, $matches);
            if ($found > 0) {
                $fatorR = collect($matches)->flatten()->unique()->shift();
            }
        }
        $fatorR = preg_replace('/[^\d,\.]/', '', $fatorR);
        return formata_moeda_db($fatorR);
    }

    private function getCpp()
    {
        $cpp = '';
        foreach ($this->contentText as $text) {
            $found = preg_match_all('/\bINSS\/CPP \d*?\.?\d*,\d*\b/m', $text, $matches);
            if ($found > 0) {
                $cpp = collect($matches)->flatten()->unique()->pop();
            }
        }
        $cpp = str_replace('INSS/CPP ', '', $cpp);
        return formata_moeda_db($cpp);
    }
}
