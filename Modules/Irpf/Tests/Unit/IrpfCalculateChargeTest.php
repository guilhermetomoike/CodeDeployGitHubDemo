<?php

namespace Modules\Irpf\Tests\Unit;

use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Services\CalculateIrpfChargeService;
use Tests\TestCase;

class IrpfCalculateChargeTest extends TestCase
{
    public function generateDeclaracaoData()
    {
        return [
            [json_encode([
                'cliente_id' => 78,
                'ano' => today()->subYear()->year,
                'qtd_lancamento' => 5,
                'rural' => false,
                'ganho_captal' => false
            ])]
        ];
    }

    /**
     * @param $json
     * @dataProvider generateDeclaracaoData
     */
    public function testCalculateWithMoreThan5Entry(string $json)
    {
        $data = json_decode($json, true);
        $data['qtd_lancamento'] = 7;
        $declaracao = DeclaracaoIrpf::query()->create($data);
        $this->assertDatabaseHas('declaracao_irpf', $data);

        $calculateService = new CalculateIrpfChargeService;
        $calculateService->setDeclaracaoIrpf($declaracao);
        $charge = $calculateService->execute()[0];

        self::assertEquals(170, $charge->getValor());
    }

    /**
     * @param $json
     * @dataProvider generateDeclaracaoData
     */
    public function testCalculateWithLessThan5Entry(string $json)
    {
        $data = json_decode($json, true);
        $data['qtd_lancamento'] = 4;
        $declaracao = DeclaracaoIrpf::query()->create($data);
        $this->assertDatabaseHas('declaracao_irpf', $data);

        $calculateService = new CalculateIrpfChargeService;
        $calculateService->setDeclaracaoIrpf($declaracao);
        $charge = $calculateService->execute()[0];

        self::assertEquals(150, $charge->getValor());
    }

    /**
     * @param $json
     * @dataProvider generateDeclaracaoData
     */
    public function testCalculateWithLessThan5EntryAndRural(string $json)
    {
        $data = json_decode($json, true);
        $data['qtd_lancamento'] = 4;
        $data['rural'] = true;
        $declaracao = DeclaracaoIrpf::query()->create($data);
        $this->assertDatabaseHas('declaracao_irpf', $data);

        $calculateService = new CalculateIrpfChargeService;
        $calculateService->setDeclaracaoIrpf($declaracao);

        $charges = $calculateService->execute();

        self::assertCount(2, $charges);

        $total = collect($charges)->sum(fn ($item) => ($item->getValor()));

        self::assertEquals(300, $total);
    }

    /**
     * @param $json
     * @dataProvider generateDeclaracaoData
     */
    public function testCalculateWithMoreThan5EntryAndRuralAndGanhoCaptal(string $json)
    {
        $data = json_decode($json, true);
        $data['qtd_lancamento'] = 9;
        $data['rural'] = true;
        $data['ganho_captal'] = true;
        $declaracao = DeclaracaoIrpf::query()->create($data);
        $this->assertDatabaseHas('declaracao_irpf', $data);

        $calculateService = new CalculateIrpfChargeService;
        $calculateService->setDeclaracaoIrpf($declaracao);

        $charges = $calculateService->execute();

        self::assertCount(3, $charges);

        $total = collect($charges)->sum(fn ($item) => ($item->getValor()));

        self::assertEquals(490, $total);
    }
}
