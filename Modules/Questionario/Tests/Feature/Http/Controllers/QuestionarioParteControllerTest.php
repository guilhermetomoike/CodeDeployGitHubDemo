<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Modules\Questionario\Entities\QuestionarioPagina;
use Modules\Questionario\Entities\QuestionarioParte;
use Tests\TestCase;

/**
 * @see \Modules\Questionario\Http\Controllers\QuestionarioParteController
 */
class QuestionarioParteControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $questionarioPartes = factory(QuestionarioParte::class, 3)->create();

        $response = $this->get(route('questionario-parte.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioParteController::class,
            'store',
            \Modules\Questionario\Http\Requests\QuestionarioParteStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $questionario_pagina = factory(QuestionarioPagina::class)->create();

        $response = $this->post(route('questionario-parte.store'), [
            'questionario_pagina_id' => $questionario_pagina->id,
        ]);

        $questionarioPartes = QuestionarioParte::query()
            ->where('questionario_pagina_id', $questionario_pagina->id)
            ->get();
        $this->assertCount(1, $questionarioPartes);
        $questionarioParte = $questionarioPartes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $questionarioParte = factory(QuestionarioParte::class)->create();

        $response = $this->get(route('questionario-parte.show', $questionarioParte));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioParteController::class,
            'update',
            \Modules\Questionario\Http\Requests\QuestionarioParteUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $questionarioParte = factory(QuestionarioParte::class)->create();
        $questionario_pagina = factory(QuestionarioPagina::class)->create();

        $response = $this->put(route('questionario-parte.update', $questionarioParte), [
            'questionario_pagina_id' => $questionario_pagina->id,
        ]);

        $questionarioParte->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($questionario_pagina->id, $questionarioParte->questionario_pagina_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $questionarioParte = factory(QuestionarioParte::class)->create();

        $response = $this->delete(route('questionario-parte.destroy', $questionarioParte));

        $response->assertNoContent();

        $this->assertDeleted($questionarioParte);
    }
}
