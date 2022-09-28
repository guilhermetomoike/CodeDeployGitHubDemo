<?php

namespace App\Modules\FileParser\Guia;

use App\Modules\FileParser\NotFoundParserException;

class Parser
{
    private $guiaContent;
    private $guiaParser;

    public function __construct(array $guiaContent)
    {
        $this->guiaContent = $guiaContent;
    }

    public function parse()
    {
        $this->identifyGuiaParser();
        if (!$this->guiaParser) {
            throw new NotFoundParserException();
        }
        return $this->guiaParser->parse();
    }

    private function identifyGuiaParser()
    {
        $guiaParsers = ParserEnum::getValues();
        foreach ($guiaParsers as $parser) {
            $guiaParser = new $parser($this->guiaContent);
            if ($guiaParser->validateType()) {
                $this->guiaParser = $guiaParser;
                return;
            }
        }
    }
}
