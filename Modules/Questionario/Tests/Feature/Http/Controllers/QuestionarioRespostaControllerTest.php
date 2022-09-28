<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Questionario\Entities\QuestionarioResposta;
use Modules\Questionario\Entities\QuestionarioRespostum;

/**
 * @see \Modules\Questionario\Http\Controllers\QuestionarioRespostaController
 */
class QuestionarioRespostaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $questionarioResposta = factory(QuestionarioResposta::class, 3)->create();

        $response = $this->get(route('questionario-resposta.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioRespostaController::class,
            'store',
            \Modules\Questionario\Http\Requests\QuestionarioRespostaStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $questionario_pergunta = factory(QuestionarioPergunta::class)->create();
        $respondente = $this->faker->word;

        $response = $this->post(route('questionario-respostum.store'), [
            'questionario_pergunta_id' => $questionario_pergunta->id,
            'respondente' => $respondente,
        ]);

        $questionarioResposta = QuestionarioResposta::query()
            ->where('questionario_pergunta_id', $questionario_pergunta->id)
            ->where('respondente', $respondente)
            ->get();
        $this->assertCount(1, $questionarioResposta);
        $questionarioRespostum = $questionarioResposta->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $questionarioRespostum = factory(QuestionarioResposta::class)->create();

        $response = $this->get(route('questionario-resposta.show', $questionarioRespostum));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioRespostaController::class,
            'update',
            \Modules\Questionario\Http\Requests\QuestionarioRespostaUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $questionarioRespostum = factory(QuestionarioResposta::class)->create();
        $questionario_pergunta = factory(QuestionarioPergunta::class)->create();
        $respondente = $this->faker->word;

        $response = $this->put(route('questionario-resposta.update', $questionarioRespostum), [
            'questionario_pergunta_id' => $questionario_pergunta->id,
            'respondente' => $respondente,
        ]);

        $questionarioRespostum->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($questionario_pergunta->id, $questionarioRespostum->questionario_pergunta_id);
        $this->assertEquals($respondente, $questionarioRespostum->respondente);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $questionarioRespostum = factory(QuestionarioResposta::class)->create();
        $questionarioRespostum = factory(QuestionarioRespostum::class)->create();

        $response = $this->delete(route('questionario-resposta.destroy', $questionarioRespostum));

        $response->assertNoContent();

        $this->assertDeleted($questionarioRespostum);
    }
}
