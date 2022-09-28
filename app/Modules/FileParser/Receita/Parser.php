<?php

namespace App\Modules\FileParser\Receita;

use App\Modules\FileParser\NotFoundParserException;

class Parser
{
    private $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function parse()
    {
        $parser = new ReceitaParser($this->content);
        if (!$parser->validateType()) {
            throw new NotFoundParserException();
        }
        return $parser->parse();
    }
}
