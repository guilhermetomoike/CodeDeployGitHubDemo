<?php

namespace Modules\Plans\Tests\Unit;

use App\Models\OrdemServico\OrdemServicoBase;
use Modules\Plans\Entities\Plan;
use Modules\Plans\Entities\ServiceTable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanHasOrderServiceTest extends TestCase
{
    use WithFaker;

    public function testCreatePlanAndAttachSyncOrderService()
    {
        $plan = Plan::create([
            'name' => 'Plano teste',
            'description' => 'description',
            'price' => 178,
        ]);

        $os_base_id = OrdemServicoBase::query()->first();

        $plan->service_order()->sync([$os_base_id->id => ['quantity' => 5]]);

        $this->assertDatabaseCount('plan_has_service_orders', 1);
        $this->assertDatabaseHas('plan_has_service_orders', [
            'os_base_id' => $os_base_id->id,
            'plan_id' => $plan->id,
            'quantity' => 5
        ]);
    }


    public function testCreatePlanAndServiceTableAndAttachSync()
    {
        $plan = Plan::create([
            'name' => 'Plano teste',
            'description' => 'description',
            'price' => 178,
        ]);

        $serviceTable = ServiceTable::query()->create([
            'name' => 'contabilidade',
            'description' => 'Description teste',
            'price' => 214,
        ]);

        $plan->service_table()->sync([$serviceTable->id => ['quantity' => 2]]);

        $this->assertDatabaseCount('plan_has_service_tables', 1);
        $this->assertDatabaseHas('plan_has_service_tables', [
            'service_table_id' => $serviceTable->id,
            'plan_id' => $plan->id,
            'quantity' => 2
        ]);
    }
}
