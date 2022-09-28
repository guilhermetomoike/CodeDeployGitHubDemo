<?php

namespace App\Services\Nfse\Common\Tomador;

use App\Models\Nfse\TomadorNfse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EnderecoTomador
{
    public $tipoLogradouro;
    public $logradouro;
    public $numero;
    public $complemento;
    public $bairro;
    public $codigoCidade;
    public $descricaoCidade;
    public $estado;
    public $cep;

    public function __construct(TomadorNfse $tomador)
    {
        $this->initialize($tomador);
    }

    private function initialize(TomadorNfse $tomador)
    {
        if (!$tomador->logradouro && !$tomador->estado) {
            $tomador = $this->buscaenderecoApi($tomador);
        }

        $this->setLogradouro($tomador->logradouro);
        $this->setBairro($tomador->bairro);
        $this->setNumero($tomador->numero);
        $this->setCep($tomador->cep);
        $this->setDescricaoCidade($tomador->descricao_cidade);
        $this->setEstado($tomador->estado);

        $this->setCodigoCidade($tomador->codigo_cidade);

        if (!$tomador->codigo_cidade) {
            $this->setCodigoCidade($this->buscaCodigoApi($tomador));
        }

    }

    /**
     * @param mixed $tipoLogradouro
     */
    public function setTipoLogradouro($tipoLogradouro): void
    {
        $this->tipoLogradouro = $tipoLogradouro;
    }

    /**
     * @param mixed $logradouro
     */
    public function setLogradouro($logradouro): void
    {
        $this->logradouro = $logradouro;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @param mixed $complemento
     */
    public function setComplemento($complemento): void
    {
        $this->complemento = $complemento;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro): void
    {
        $this->bairro = $bairro;
    }

    /**
     * @param mixed $codigoCidade
     */
    public function setCodigoCidade($codigoCidade): void
    {
        $this->codigoCidade = "$codigoCidade";
    }

    /**
     * @param mixed $descricaoCidade
     */
    public function setDescricaoCidade($descricaoCidade): void
    {
        $this->descricaoCidade = $descricaoCidade;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep): void
    {
        $this->cep = $cep;
    }

    private function buscaCodigoApi($tomador)
    {
        $consulta1 = consulta_cep1($tomador->cep);
        if ($consulta1) {
            $tomador->update(['codigo_cidade' => $consulta1->ibge]);
            return $consulta1->ibge;
        }

        $cep_info = zipcode($tomador->cep);
        if ($cep_info) {
            $cepObject = $cep_info->getObject();
            $this->setCodigoCidade($cepObject->ibge);
            $tomador->update(['codigo_cidade' => $cepObject->ibge]);
            return $cepObject->ibge;
        }

        throw new HttpException(500, 'Erro ao buscar o código do tomador. Tente novemente em alguns instantes');
    }

    private function buscaenderecoApi(TomadorNfse $tomador)
    {
        $consulta1 = consulta_cep1($tomador->cep);
        if ($consulta1) {
            $tomador = $tomador->update([
                'codigo_cidade' => $consulta1->ibge,
                'logradouro' => $consulta1->logradouro,
                'complemento' => $consulta1->complemento ?? null,
                'bairro' => $consulta1->bairro,
                'descricao_cidade' => $consulta1->municipio,
                'estado' => $consulta1->uf,
            ]);
        }

        $cep_info = zipcode($tomador->cep);
        if ($cep_info) {
            $cepObject = $cep_info->getObject();
            $this->setCodigoCidade($cepObject->ibge);
            $tomador = $tomador->update([
                'codigo_cidade' => $cepObject->ibge,
                'logradouro' => $cepObject->logradouro,
                'complemento' => $cepObject->complemento ?? null,
                'bairro' => $cepObject->bairro,
                'numero' => $cepObject->numero,
                'descricao_cidade' => $cepObject->localidade,
                'estado' => $cepObject->uf,
            ]);
        }

        if($tomador) {
            return $tomador->refresh();
        }
        throw new HttpException(500, 'Erro ao buscar o código do tomador. Tente novemente em alguns instantes');
    }
}