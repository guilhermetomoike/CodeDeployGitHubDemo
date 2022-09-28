<?php

namespace App\Exceptions;

use Exception;

class RegisterInvoiceException extends Exception
{
    public function __construct(string $message, int $code) {
        parent::__construct('Erro no registro da fatura: ' . $message, $code);
    }
}
