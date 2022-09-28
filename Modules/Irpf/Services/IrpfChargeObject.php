<?php


namespace Modules\Irpf\Services;


class IrpfChargeObject
{
    private string $descricao;
    private float $valor;
    private int $qtd;

    public static function create()
    {
        return new static();
    }
    /**
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     * @return IrpfChargeObject
     */
    public function setDescricao(string $descricao): IrpfChargeObject
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return float
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * @param float $valor
     * @return IrpfChargeObject
     */
    public function setValor(float $valor): IrpfChargeObject
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @return int
     */
    public function getQtd(): int
    {
        return $this->qtd;
    }

    /**
     * @param int $qtd
     * @return IrpfChargeObject
     */
    public function setQtd(int $qtd): IrpfChargeObject
    {
        $this->qtd = $qtd;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'descricao' => $this->descricao,
            'valor' => $this->valor,
            'qtd' => $this->qtd
        ];
    }
}
