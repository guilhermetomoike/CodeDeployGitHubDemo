<?php

namespace App\Services\Nfse\Common\Prestador;

use App\Models\Empresa;

class Prestador
{
    public $certificado;
    public $cpfCnpj;
    public $email;
    public $inscricaoMunicipal;
    public $nomeFantasia;
    public $razaoSocial;
    public $regimeTributario;
    public $regimeTributarioEspecial;
    public $simplesNacional;
    public $telefone;
    public $endereco;

    public function __construct($empresa)
    {
        $this->buildPrestador($empresa);
    }

    private function buildPrestador($empresa)
    {
        $this->setCpfCnpj($empresa->cnpj);

        if ($empresa->tem_cadastro_plugnotas) {
            return;
        }

        $this->setRazaoSocial($empresa->razao_social);
        $this->setSimplesNacional($empresa->regime_tributario == 'SN' ? true : false);
        $this->setInscricaoMunicipal($empresa->inscricao_municipal);

        $this->setEndereco(new EnderecoPrestador($empresa->endereco));
        $this->setCertificado($empresa->certificado_digital->id_integracao ?? null);
        $this->setRegimeTributario($empresa->regime_tributario == 'SN' ? 1 : 3);
        $this->setRegimeTributarioEspecial(6);
        $this->setConfig();
    }

    /**
     * @param mixed $certificado
     */
    public function setCertificado($certificado): void
    {
        $this->certificado = $certificado;
    }

    /**
     * @param mixed $cpfCnpj
     */
    public function setCpfCnpj($cpfCnpj): void
    {
        $this->cpfCnpj = $cpfCnpj;
    }

    public function getCpfCnpj(): string
    {
        return $this->cpfCnpj;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $inscricaoMunicipal
     */
    public function setInscricaoMunicipal($inscricaoMunicipal): void
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
    }

    /**
     * @param mixed $nomeFantasia
     */
    public function setNomeFantasia($nomeFantasia): void
    {
        $this->nomeFantasia = $nomeFantasia;
    }

    /**
     * @param mixed $razaoSocial
     */
    public function setRazaoSocial($razaoSocial): void
    {
        $this->razaoSocial = $razaoSocial;
    }

    /**
     * @param mixed $regimeTributario
     */
    public function setRegimeTributario($regimeTributario): void
    {
        $this->regimeTributario = $regimeTributario;
    }

    /**
     * @param mixed $regimeTributarioEspecial
     */
    public function setRegimeTributarioEspecial($regimeTributarioEspecial): void
    {
        $this->regimeTributarioEspecial = $regimeTributarioEspecial;
    }

    /**
     * @param mixed $simplesNacional
     */
    public function setSimplesNacional($simplesNacional): void
    {
        $this->simplesNacional = $simplesNacional;
    }

    /**
     * @param mixed $ddd
     * @param $numero
     */
    public function setTelefone($ddd, $numero): void
    {
        $this->telefone = [
            'ddd' => $ddd,
            'numero' => $numero
        ];
    }

    /**
     * @param EnderecoPrestador $endereco
     */
    public function setEndereco(EnderecoPrestador $endereco): void
    {
        $this->endereco = $endereco;
    }

    private function setConfig()
    {
        $this->nfse = [
            'ativo' => true,
            'config' => [
                'producao' => true,
            ]
        ];
    }
}
