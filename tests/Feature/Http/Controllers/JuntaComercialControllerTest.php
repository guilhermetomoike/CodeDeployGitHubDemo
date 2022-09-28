<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\JuntaComercial;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\JuntaComercialController
 */
class JuntaComercialControllerTest extends TestCase
{
    use AdditionalAssertions, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $user = Usuario::find(44);

        $juntaComercials = factory(JuntaComercial::class, 3)->create();

        $response = $this->actingAs($user, 'api_usuarios')
                        ->json('get', '/junta-comercial')
                        ->assertJson([
                            'data' => $juntaComercials->toArray(),
                        ]);
    }

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JuntaComercialController::class,
            'store',
            \App\Http\Requests\JuntaComercialStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $juntaComercial = $this->faker->word;

        $response = $this->post(route('junta-comercial.store'), [
            'juntaComercial' => $juntaComercial,
        ]);

        $juntaComercials = JuntaComercial::query()
            ->where('juntaComercial', $juntaComercial)
            ->get();
        $this->assertCount(1, $juntaComercials);
        $juntaComercial = $juntaComercials->first();
    }

    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $juntaComercial = factory(JuntaComercial::class)->create();

        $response = $this->get(route('junta-comercial.show', $juntaComercial));
    }

    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\JuntaComercialController::class,
            'update',
            \App\Http\Requests\JuntaComercialUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $juntaComercial = factory(JuntaComercial::class)->create();
        $juntaComercial = $this->faker->word;

        $response = $this->put(route('junta-comercial.update', $juntaComercial), [
            'juntaComercial' => $juntaComercial,
        ]);
    }

    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $juntaComercial = factory(JuntaComercial::class)->create();

        $response = $this->delete(route('junta-comercial.destroy', $juntaComercial));

        $response->assertOk();

        $this->assertDeleted($juntaComercial);
    }
}
