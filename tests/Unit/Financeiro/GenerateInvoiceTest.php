<?php

namespace Tests\Unit\Financeiro;

use App\Models\Empresa;
use App\Services\Recebimento\Gatway\Iugu\IuguService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerateInvoiceTest extends TestCase
{
    use WithFaker;

    public function makeEmpresaSut()
    {
        $empresa = factory(Empresa::class)->create();
        $socio = $this->makeClienteSut();
        $plan = $this->makePlanSut();

        $empresa->socios()->sync($socio);
        $empresa->plans()->sync($plan);
        $empresa->alvara()->create([
            'data_vencimento' => today()
        ]);

        return $empresa;
    }

    public function testCreate()
    {
        $empresa = $this->makeEmpresaSut();
        $empresa->iugu_id = $this->faker->uuid;

        $this->createMock(IuguService::class)
            ->method('criarFatura')
            ->willReturn((object)[
                'id' => $this->faker->uuid,
                'secure_url' => $this->faker->url,
                'pix' => ['qrcode_text' => $this->faker->uuid],
            ]);

    }
}
