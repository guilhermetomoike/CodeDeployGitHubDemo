<?php

namespace Modules\Plans\Tests\Feature;

use App\Models\OrdemServico\OrdemServicoBase;
use App\Models\Usuario;
use Modules\Plans\Entities\PlansIntervalType;
use Modules\Plans\Entities\PlansPayableWith;
use Modules\Plans\Entities\ServiceTable;
use Spatie\Permission\Models\Role;
use Tests\JwtAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlansTest extends TestCase
{
    use WithFaker, JwtAuth;

    public function testCreatePlan()
    {
        $this->actingAs(Usuario::find(44));
        $os_base_array = $this->getOsBaseData();
        $os_base = $this->setOsBase($os_base_array);
        $service_table_array = $this->getServiceTableData();
        $service_table = $this->setServiceTable($service_table_array);

        $data = [
            'name' => $this->faker->text(20),
            'description' => $this->faker->text(50),
            'price' => 250,
            'interval' => 1,
            'interval_type' => PlansIntervalType::MONTHLY,
            'payable_with' => PlansPayableWith::ALL,
            'os_base' => [
                [
                    'os_base_id' => $os_base->id,
                    'quantity' => 2,
                ]
            ],
            'service_tables' => [
                [
                    'service_table_id' => $service_table->id,
                    'quantity' => 1
                ]
            ]
        ];

        $response = $this->postJson('plans', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('plan_has_service_orders', $data['os_base'][0]);
        unset($data['os_base']);

        $this->assertDatabaseHas('plan_has_service_tables', $data['service_tables'][0]);
        unset($data['service_tables']);

        $this->assertDatabaseHas('plans', $data);
    }

    private function setOsBase(array $data)
    {
        return OrdemServicoBase::query()->create($data);
    }

    private function getOsBaseData(): array
    {
        return [
            'nome' => $this->faker->words(3, true),
            'descricao' => $this->faker->text(40),
            'preco' => $this->faker->numberBetween(10, 200),
            'role_id' => Role::first()->id,
            'procedimento_interno' => 1,
            'pagamento_antecipado' => 1
        ];
    }

    private function setServiceTable(array $data)
    {
        return ServiceTable::query()->create($data);
    }

    private function getServiceTableData(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->text(40),
            'price' => $this->faker->numberBetween(10, 200),
        ];
    }
}
