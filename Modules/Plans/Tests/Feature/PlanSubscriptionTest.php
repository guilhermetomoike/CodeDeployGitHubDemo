<?php

namespace Modules\Plans\Tests\Feature;

use App\Models\Usuario;
use Modules\Plans\Entities\Plan;
use Tests\JwtAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanSubscriptionTest extends TestCase
{
    use WithFaker, JwtAuth;

    public function testListSubscription()
    {
        $this->actingAs(Usuario::find(44));
        $data = $this->dataProvider();

        $response = $this->post('/plans/subscription', $data);
        $response->assertStatus(201);

        $response = $this->get('/plans/subscription');
        $response->assertStatus(200);
    }

    public function testPlanSubscription()
    {
        $this->actingAs(Usuario::find(44));
        $data = $this->dataProvider();

        $response = $this->post('/plans/subscription', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('plan_subscriptions', [
            'payer_id' => $data['payer_id'],
            'payer_type' => $data['payer_type'],
            'plan_id' => $data['plans'][0]['plan_id'],
        ]);

        $this->assertDatabaseCount('plan_subscriptions', 2);
    }

    public function dataProvider(): array
    {
        $plan1 = $this->createPlan();
        $plan2 = $this->createPlan();
        return [
            'payer_id' => 74,
            'payer_type' => 'empresa',
            'plans' => [
                ['plan_id' => $plan1->id],
                ['plan_id' => $plan2->id],
            ]
        ];
    }

    public function createPlan()
    {
        return Plan::query()->create([
            'name' => $this->faker->text(50),
            'description' => $this->faker->text(100),
            'price' => $this->faker->numberBetween(50, 200),
        ]);
    }
}
