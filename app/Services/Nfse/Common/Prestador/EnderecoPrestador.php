<?php


namespace App\Services\Nfse\Common\Prestador;


use App\Models\EmpresaEndereco;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EnderecoPrestador
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

    public function __construct(EmpresaEndereco $endereco)
    {
        $this->initialize($endereco);
    }

    private function initialize(EmpresaEndereco $endereco)
    {
        $this->setLogradouro($endereco->logradouro);
        $this->setBairro($endereco->bairro);
        $this->setNumero($endereco->numero);
        $this->setCep($endereco->cep);
        $this->setDescricaoCidade($endereco->cidade);
        $this->setEstado($endereco->uf);

        $this->setCodigoCidade($endereco->codigo_ibge);

        if (!$endereco->codigo_ibge) {
            $this->setCodigoCidade($this->buscaCodigoApi($endereco));
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

    private function buscaCodigoApi($endereco)
    {
        $consulta1 = consulta_cep1($endereco->cep);
        if ($consulta1) {
            $endereco->update(['codigo_ibge' => $consulta1->ibge]);
            return $consulta1->ibge;
        }

        $cep_info = zipcode($endereco->cep);
        if ($cep_info) {
            $cepObject = $cep_info->getObject();
            $this->setCodigoCidade($cepObject->ibge);
            $endereco->update(['codigo_ibge' => $cepObject->ibge]);
            return $cepObject->ibge;
        }

        throw new HttpException(500, 'Erro ao buscar o código do prestador. Tente novemente em alguns instantes');

    }
}