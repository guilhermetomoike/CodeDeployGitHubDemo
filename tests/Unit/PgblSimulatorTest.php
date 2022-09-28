<?php

namespace Tests\Unit;


use App\Http\Controllers\SimuladorController;
use App\Models\Usuario;
use Tests\JwtAuth;
use Tests\TestCase;

class PgblSimulatorTest extends TestCase
{
    use JwtAuth;

    public function testExample()
    {
        $request = $this->actingAs(Usuario::find(99));
        $response = $request->getJson('simulator/pgbl/74');
        $response->assertOk();
    }
}
