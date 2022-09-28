<?php


namespace App\Services\Recebimento\Contracts;


use Modules\Invoice\Entities\Fatura;

interface Recebimento
{
    public function criarFaturaWithItems(Fatura $fatura): Fatura;
}
