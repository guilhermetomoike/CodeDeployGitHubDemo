<?php


namespace App\Services\Nfse\Plugnotas\Common;


use App\Services\Nfse\Common\Prestador\Prestador;
use App\Services\Nfse\Common\Servico\Servico;
use App\Services\Nfse\Common\Tomador\Tomador;

class Nfse
{
    public $prestador;
    public $tomador;
    public $servico;
    public $enviarEmail = true;
    public $config = [
        'producao' => true,
    ];

    /**
     * Nfse constructor.
     * @param Prestador $prestador
     * @param Tomador $tomador
     * @param Servico $servico
     */
    public function __construct(Prestador $prestador, Tomador $tomador, Servico $servico)
    {
        $this->prestador = $prestador;
        $this->tomador = $tomador;
        $this->servico = $servico;
    }

    public function setPrestador($prestador): Nfse
    {
        $this->prestador = $prestador;
        return $this;
    }

    public function setTomador($tomador): Nfse
    {
        $this->tomador = $tomador;
        return $this;
    }

    public function setServico($servico): Nfse
    {
        $this->servico = $servico;
        return $this;
    }

    public function setProducao(bool $value): Nfse
    {
        $this->config['producao'] = $value;
        return $this;
    }

    public function setRpsLote(int $value): Nfse
    {
        $this->config['rps']['lote'] = $value;
        return $this;
    }

    public function setRpsSerie($value): Nfse
    {
        $this->config['rps']['serie'] = $value;
        return $this;
    }

    public function toArray($withNulls = false)
    {
        $array = json_decode(json_encode($this), true);

        return !$withNulls ? remove_null_recursive($array) : $array;
    }

}