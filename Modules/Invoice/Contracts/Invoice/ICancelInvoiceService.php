<?php

namespace Modules\Invoice\Contracts\Invoice;

use Modules\Invoice\Entities\Fatura;

interface ICancelInvoiceService
{
    public function execute(int $fatura_id);
}
