<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Modules\Questionario\Entities\Questionario;
use Tests\TestCase;

/**
 * @see \Modules\Questionario\Http\Controllers\QuestionarioController
 */
class QuestionarioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $questionarios = factory(Questionario::class, 3)->create();

        $response = $this->get(route('questionario.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioController::class,
            'store',
            \Modules\Questionario\Http\Requests\QuestionarioStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $titulo = $this->faker->word;

        $response = $this->post(route('questionario.store'), [
            'titulo' => $titulo,
        ]);

        $questionarios = Questionario::query()
            ->where('titulo', $titulo)
            ->get();
        $this->assertCount(1, $questionarios);
        $questionario = $questionarios->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $questionario = factory(Questionario::class)->create();

        $response = $this->get(route('questionario.show', $questionario));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioController::class,
            'update',
            \Modules\Questionario\Http\Requests\QuestionarioUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $questionario = factory(Questionario::class)->create();
        $titulo = $this->faker->word;

        $response = $this->put(route('questionario.update', $questionario), [
            'titulo' => $titulo,
        ]);

        $questionario->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($titulo, $questionario->titulo);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $questionario = factory(Questionario::class)->create();

        $response = $this->delete(route('questionario.destroy', $questionario));

        $response->assertNoContent();

        $this->assertDeleted($questionario);
    }
}
