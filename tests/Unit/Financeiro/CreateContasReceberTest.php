<?php

namespace Tests\Unit\Financeiro;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Repositories\CrmRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Invoice\Repositories\ContasReceberRepository;
use Modules\Invoice\Repositories\MovimentoContasReceberRepository;
use Modules\Invoice\Services\ContasReceber\CreateContasReceberService;
use Modules\Invoice\Services\ContasReceber\CreateMovimentacaoService;
use Modules\Plans\Entities\Plan;
use Tests\TestCase;

class CreateContasReceberTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::table('contas_receber')->delete();
        $this->withoutEvents();
        $this->withoutJobs();
    }

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

    public function makeClienteSut()
    {
        $socio = factory(Cliente::class)->create();
        $socio->crm()->create([
            'numero' => '123',
            'senha' => 'senha',
            'estado' => 'pr',
            'data_emissao' => today()->subDay()
        ]);
        $plan = $this->makePlanSut();
        $socio->plans()->sync($plan);
        return $socio;
    }

    public function makePlanSut()
    {
        return factory(Plan::class)->create();
    }

    public function makeCreateContasReceberSut()
    {
        $contasReceberRepository = new ContasReceberRepository(new MovimentoContasReceberRepository());
        return new CreateContasReceberService(new CrmRepository, $contasReceberRepository);
    }

    public function makeCreateMovementContasReceberSut()
    {
        $movementContasreceberRepository = new MovimentoContasReceberRepository();
        return new CreateMovimentacaoService(
            $movementContasreceberRepository,
            new ContasReceberRepository(
                $movementContasreceberRepository
            )
        );
    }

    public function testShouldCreateContasReceberWithCorrectValues()
    {
        Carbon::setTestNow(today()->firstOfMonth());
        $contasReceberService = $this->makeCreateContasReceberSut();
        $empresaSut = $this->makeEmpresaSut();
        $price = $empresaSut->plans()->sum('price');

        $contasReceberService->createContasReceberByPayer($empresaSut);

        $this->assertDatabaseCount('contas_receber', 6);

        $this->assertDatabaseHas('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->setDay(15),
        ]);

        $this->assertDatabaseHas('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->setDay(15)->addMonths(5),
        ]);

        $this->assertDatabaseMissing('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->setDay(15)->addMonths(6),
        ]);
    }

    public function testShouldCreateContasReceberWithCorrectValuesAfterHalfTheMonth()
    {
        Carbon::setTestNow(today()->setDay(16));
        $contasReceberService = $this->makeCreateContasReceberSut();
        $empresaSut = $this->makeEmpresaSut();
        $price = $empresaSut->plans()->sum('price');

        $contasReceberService->createContasReceberByPayer($empresaSut);

        $this->assertDatabaseCount('contas_receber', 6);

        $this->assertDatabaseHas('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->addMonth()->setDay(15),
        ]);

        $this->assertDatabaseHas('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->addMonths(6)->setDay(15),
        ]);

        $this->assertDatabaseMissing('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->addMonths(7)->setDay(15),
        ]);
    }

    public function testShouldCreateContasReceberWithCorrectValuesWithSociosWithoutCrmAndCompanyWithCrm()
    {
        Carbon::setTestNow(today()->setDay(20));
        $contasReceberService = $this->makeCreateContasReceberSut();
        $empresaSut = $this->makeEmpresaSut();
        $price = $empresaSut->plans()->sum('price');

        $empresaSut->socios->each(fn($socio) => $socio->crm()->delete());
        $empresaSut->crm()->create([
            'numero' => '123',
            'senha' => 'senha',
            'estado' => 'pr',
            'data_emissao' => today()->subDay()
        ]);

        $contasReceberService->createContasReceberByPayer($empresaSut);

        $this->assertDatabaseCount('contas_receber', 6);

        $this->assertDatabaseHas('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->addMonth()->setDay(15),
        ]);

        $this->assertDatabaseHas('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->addMonths(6)->setDay(15),
        ]);

        $this->assertDatabaseMissing('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->addMonths(7)->setDay(15),
        ]);
    }

    public function testShouldCreateContasReceberForClienteWithCorrectValues()
    {
        Carbon::setTestNow(today()->setDay(16));
        $clienteSut = $this->makeClienteSut();
        $contasReceberService = $this->makeCreateContasReceberSut();
        $price = $clienteSut->plans()->sum('price');

        $contasReceberService->createContasReceberByPayer($clienteSut);

        $this->assertDatabaseCount('contas_receber', 6);
        $this->assertDatabaseHas('contas_receber', [
            'payer_id' => $clienteSut->id,
            'valor' => $price,
            'vencimento' => today()->addMonth()->setDay(15),
        ]);
        $this->assertDatabaseHas('contas_receber', [
            'payer_id' => $clienteSut->id,
            'valor' => $price,
            'vencimento' => today()->addMonths(6)->setDay(15),
        ]);
        $this->assertDatabaseMissing('contas_receber', [
            'payer_id' => $clienteSut->id,
            'valor' => $price,
            'vencimento' => today()->addMonths(7)->setDay(15),
        ]);
    }

    public function testShouldNotCreateContasReceberWhenCompanyThereIsNoAlvara()
    {
        Carbon::setTestNow(today()->firstOfMonth());
        $contasReceberService = $this->makeCreateContasReceberSut();
        $empresaSut = $this->makeEmpresaSut();
        $price = $empresaSut->plans()->sum('price');
        $empresaSut->alvara()->delete();

        $contasReceberService->createContasReceberByPayer($empresaSut);

        $this->assertDatabaseCount('contas_receber', 0);

        $this->assertDatabaseMissing('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->setDay(15),
        ]);
    }

    public function testShouldNotCreateContasReceberWhenCompanyThereIsNoCrm()
    {
        Carbon::setTestNow(today()->firstOfMonth());
        $contasReceberService = $this->makeCreateContasReceberSut();
        $empresaSut = $this->makeEmpresaSut();
        $price = $empresaSut->plans()->sum('price');

        $empresaSut->crm()->delete();
        $empresaSut->socios->each(fn($socio) => ($socio->crm()->delete()));

        $contasReceberService->createContasReceberByPayer($empresaSut);

        $this->assertDatabaseCount('contas_receber', 0);

        $this->assertDatabaseMissing('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price,
            'vencimento' => today()->setDay(15),
        ]);
    }

    public function testShouldDecreaseFromContasReceberWhenCreateMovementNegative()
    {
        DB::table('movimento_contas_receber')->delete();
        Carbon::setTestNow(today()->firstOfMonth());
        $movementContasReceber = $this->makeCreateMovementContasReceberSut();
        $empresaSut = $this->makeEmpresaSut();
        $price = $empresaSut->plans()->sum('price');
        $discount = $price / 2;
        $vencimento = today()->setDay(15)->format('Y-m-d');

        $conta = (new ContasReceberRepository(new MovimentoContasReceberRepository()))
            ->createContasReceber([
                'vencimento' => $vencimento,
                'valor' => (float)$price,
                'descricao' => 'Honorário mensal',
                'payer_type' => 'empresa',
                'payer_id' => $empresaSut->id,
            ]);

        $movementContasReceber->createMoviment([
            'contaReceberId' => $conta->id,
            'valor' => $discount,
            'descricao' => 'Desconto de teste',
        ]);

        $this->assertDatabaseCount('contas_receber', 1);
        $this->assertDatabaseCount('movimento_contas_receber', 2);

        $this->assertDatabaseHas('contas_receber', [
            'payer_id' => $empresaSut->id,
            'valor' => $price + $discount,
            'vencimento' => $vencimento,
        ]);

        $this->assertDatabaseHas('movimento_contas_receber', [
            'contas_receber_id' => $conta->id,
            'valor' => $price - $discount,
        ]);
    }
}
