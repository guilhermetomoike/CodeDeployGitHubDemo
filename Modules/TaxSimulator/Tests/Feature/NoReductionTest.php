<?php


namespace Modules\TaxSimulator\Tests\Feature;


use Modules\TaxSimulator\Services\NoReductionService;
use Modules\TaxSimulator\Services\WithReductionService;
use Tests\TestCase;

class NoReductionTest extends TestCase
{
    public function testResult()
    {
        $withReduction = new NoReductionService();

        $data = [
            "value" => 250000.0,
            "iss" => 0.05
        ];

        $result = $withReduction->withReduction($data);

        $this->assertEquals(19500, $result['pis']);
        $this->assertEquals(90000, $result['cofins']);
        $this->assertEquals(150000, $result['iss']);
        $this->assertEquals(86400, $result['csll']);
        $this->assertEquals(144000, $result['irpj']);
        $this->assertEquals(72000, $result['additional']);
    }
}
