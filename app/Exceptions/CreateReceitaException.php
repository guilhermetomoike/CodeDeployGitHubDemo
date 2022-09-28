<?php

namespace App\Exceptions;

class CreateReceitaException extends \Exception
{
    public function __construct(string $message) {
        parent::__construct('Erro na criação da receita: ' . $message);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
