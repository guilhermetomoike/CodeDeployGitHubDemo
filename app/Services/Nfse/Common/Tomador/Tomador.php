<?php


namespace App\Services\Nfse\Common\Tomador;


use App\Models\Nfse\TomadorNfse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Tomador
{
    public $cpfCnpj;
    public $razaoSocial;
    public $nomeFantasia;
    public $endereco;
    public $email;

    /**
     * Tomador constructor.
     * @param TomadorNfse $tomador
     * @param bool $completo
     */
    public function __construct(TomadorNfse $tomador, $completo = false)
    {
        $this->buildTomador($tomador, $completo);
    }

    private function buildTomador(TomadorNfse $tomador, $completo)
    {
        $this->setCpfCnpj($tomador->cpf_cnpj);

        if($tomador->tem_cadastro_plugnotas && !$completo){
            return;
        }

        $this->setRazaoSocial($tomador->razao_social);
        $this->setNomeFantasia($tomador->nome_fantasia);
        $this->setEndereco(new EnderecoTomador($tomador));
    }

    public function setCpfCnpj($cpfCnpj): void
    {
        $this->cpfCnpj = $cpfCnpj;
    }

    public function setRazaoSocial($razaoSocial): void
    {
        $this->razaoSocial = $razaoSocial;
    }

    public function setEndereco($endereco): void
    {
        $this->endereco = $endereco;
    }

    public function setNomeFantasia($nomeFantasia): void
    {
        $this->nomeFantasia = $nomeFantasia;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }
}
