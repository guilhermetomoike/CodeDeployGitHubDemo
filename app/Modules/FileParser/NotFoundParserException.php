<?php

namespace App\Modules\FileParser;

use Exception;

class NotFoundParserException extends Exception
{

    public function __construct() {
        parent::__construct('Not found parser.');
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
