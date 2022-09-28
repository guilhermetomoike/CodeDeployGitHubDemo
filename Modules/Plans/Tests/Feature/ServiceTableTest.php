<?php

namespace Modules\Plans\Tests\Feature;

use App\Models\Usuario;
use Modules\Plans\Entities\ServiceTable;
use Tests\JwtAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ServiceTableTest extends TestCase
{
    use WithFaker, JwtAuth;

    private function authenticateUser()
    {
        $user = Usuario::find(44);
        $this->actingAs($user, 'api_usuarios');
        return $user;
    }

    private function dataProvider()
    {
        return [
            'name' => $this->faker->text(25),
            'description' => $this->faker->words(5, true),
            'price' => $this->faker->randomFloat(2, 2, 3)
        ];
    }

    public function testCreateService()
    {
        $this->authenticateUser();

        $data = $this->dataProvider();

        $response = $this->json('post', 'plans/service-table', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('service_tables', $data);

        $data['description'] = null;
        $response = $this->json('post', 'plans/service-table', $data);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('service_tables', $data);
    }

    public function testUpdateService()
    {
        $this->authenticateUser();
        $data = $this->dataProvider();

        $service_table = ServiceTable::query()->create($data);
        $this->assertDatabaseHas('service_tables', $data);

        $data['name'] = $this->faker->text(25);

        $response = $this->patchJson('plans/service-table/' . $service_table->id, $data);
        $response->assertJson(['data' => $data]);
    }

    public function testGetService()
    {
        $this->authenticateUser();
        $data = $this->dataProvider();

        $service_table = ServiceTable::query()->create($data);
        $this->assertDatabaseHas('service_tables', $data);

        $data['name'] = $this->faker->text(25);

        $response = $this->patchJson('plans/service-table/' . $service_table->id, $data);
        $response->assertJson(['data' => $data]);
    }

    public function testDeleteService()
    {
        $this->authenticateUser();
        $data = $this->dataProvider();

        $service_table = ServiceTable::query()->create($data);
        $this->assertDatabaseHas('service_tables', $data);

        $data['name'] = $this->faker->text(25);

        $response = $this->deleteJson('plans/service-table/' . $service_table->id);
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseMissing('service_tables', $data);
    }
}
