<?php


namespace App\Services\Nfse\Common\Servico;


use App\Models\Nfse\ServicoNfse;

class Servico
{
    public $id;
    public $discriminacao;
    public $valor;
    public $iss;

    /**
     * Servico constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->build($attributes);
    }

    private function build(array $attributes)
    {
        $this->setId($attributes['servico_id']);
        $this->setDiscriminacao($attributes['discriminacao']);
        $this->setValor($attributes['valor']);
        $this->setAliquota($attributes['aliquota']);
        $this->setRetido($attributes['iss_retido'] ?? false);
        $this->setRetencao($attributes['retencao'] ?? false);
    }

    public function setId($id): void
    {
        $this->id = ServicoNfse::find($id)->id_plugnotas;
    }

    public function setDiscriminacao($discriminacao): void
    {
        $this->discriminacao = preg_replace('/\n+/', '|', strip_tags(clean_string($discriminacao)));
    }

    public function setValor($valor): void
    {
        $this->valor = ['servico' => $valor];
    }

    public function setIss($iss): void
    {
        $this->iss = $iss;
    }

    public function setRetencao($retencao)
    {
        if (!$retencao) return;

        foreach ($retencao as $key => &$item) {
            if (is_array($item) && array_key_exists('aliquota', $item)) {
                if ($item['aliquota'] === null) {
                    unset($retencao[$key]);
                    continue;
                }
                $item['aliquota'] = (float)formata_moeda_db($item['aliquota'] ?? 0);
            } else {
                $item = (float)formata_moeda_db($item['aliquota'] ?? 0);
            }
        }

        if (!$retencao) return;

        $this->iss['retencao'] = $retencao;
    }

    public function setAliquota($aliquota)
    {
        $this->iss['aliquota'] = formata_moeda_db($aliquota);
    }

    public function setRetido($retido)
    {
        $this->iss['retido'] = boolval($retido);
    }


}
