<?php

namespace App\Modules\FileParser\CertidaoNegativa;

class CertidaoNegativaParser
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
            'tipo' => 'Federal',
            'data_emissao' => $this->getDataEmissao(),
            'data_validade' => $this->getDataValidade(),
        ];
    }

    public function validateType()
    {
        foreach ($this->contentText as $text) {
            $found = preg_match_all("/\b(CERTIDAO NEGATIVA DE DEBITOS|CERTIDAO POSITIVA COM EFEITOS DE NEGATIVA DE DEBITOS)\b/m", $text);
            return $found > 0;
        }
        return false;
    }

    private function getCnpj()
    {
        $cnpj = '';
        foreach ($this->contentText as $text) {
            $found = preg_match_all('/\bCNPJ: \d{2,3}\.\d{3}\.\d{3}\/\d{4}\-\d{2}\b/m', $text, $matches);
            if ($found > 0) {
                $cnpj = collect($matches)->flatten()->unique()->pop();
            }
        }
        $cnpj = str_replace('CNPJ: ', '', $cnpj);
        return formata_cnpj_bd($cnpj);
    }

    private function getDataEmissao()
    {
        $date = '';
        foreach ($this->contentText as $text) {
            $found = preg_match_all('/\bdo dia [0-9]{2}\/[0-9]{2}\/[0-9]{4}\b/m', $text, $matches);
            if ($found > 0) {
                $date = collect($matches)->flatten()->unique()->pop();
            }
        }
        $date = str_replace('do dia ', '', $date);
        $date = str_replace('/', '-', $date);
        return $date;
    }

    private function getDataValidade()
    {
        $date = '';
        foreach ($this->contentText as $text) {
            $found = preg_match_all('/\bValida ate [0-9]{2}\/[0-9]{2}\/[0-9]{4}\b/m', $text, $matches);
            if ($found > 0) {
                $date = collect($matches)->flatten()->unique()->pop();
            }
        }
        $date = str_replace('Valida ate ', '', $date);
        $date = str_replace('/', '-', $date);
        return $date;
    }
}
