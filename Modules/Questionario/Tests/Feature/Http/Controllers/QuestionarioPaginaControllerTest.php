<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Modules\Questionario\Entities\Questionario;
use Modules\Questionario\Entities\QuestionarioPagina;
use Tests\TestCase;

/**
 * @see \Modules\Questionario\Http\Controllers\QuestionarioPaginaController
 */
class QuestionarioPaginaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $questionarioPaginas = factory(QuestionarioPagina::class, 3)->create();

        $response = $this->get(route('questionario-pagina.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioPaginaController::class,
            'store',
            \Modules\Questionario\Http\Requests\QuestionarioPaginaStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $questionario = factory(Questionario::class)->create();

        $response = $this->post(route('questionario-pagina.store'), [
            'questionario_id' => $questionario->id,
        ]);

        $questionarioPaginas = QuestionarioPagina::query()
            ->where('questionario_id', $questionario->id)
            ->get();
        $this->assertCount(1, $questionarioPaginas);
        $questionarioPagina = $questionarioPaginas->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $questionarioPagina = factory(QuestionarioPagina::class)->create();

        $response = $this->get(route('questionario-pagina.show', $questionarioPagina));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioPaginaController::class,
            'update',
            \Modules\Questionario\Http\Requests\QuestionarioPaginaUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $questionarioPagina = factory(QuestionarioPagina::class)->create();
        $questionario = factory(Questionario::class)->create();

        $response = $this->put(route('questionario-pagina.update', $questionarioPagina), [
            'questionario_id' => $questionario->id,
        ]);

        $questionarioPagina->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($questionario->id, $questionarioPagina->questionario_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $questionarioPagina = factory(QuestionarioPagina::class)->create();

        $response = $this->delete(route('questionario-pagina.destroy', $questionarioPagina));

        $response->assertNoContent();

        $this->assertDeleted($questionarioPagina);
    }
}
