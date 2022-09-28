<?php


namespace Modules\Invoice\Contracts\Invoice;


use App\Services\Recebimento\Gatway\Iugu\Common\IuguFatura;

interface ICreateInvoiceService
{
    public function execute(IuguFatura $fatura): array;
}
