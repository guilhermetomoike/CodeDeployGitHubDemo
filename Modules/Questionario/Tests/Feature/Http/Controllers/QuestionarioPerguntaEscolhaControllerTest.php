<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Modules\Questionario\Entities\QuestionarioPergunta;
use Modules\Questionario\Entities\QuestionarioPerguntaEscolha;
use Tests\TestCase;

/**
 * @see \Modules\Questionario\Http\Controllers\QuestionarioPerguntaEscolhaController
 */
class QuestionarioPerguntaEscolhaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $questionarioPerguntaEscolhas = factory(QuestionarioPerguntaEscolha::class, 3)->create();

        $response = $this->get(route('questionario-pergunta-escolha.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioPerguntaEscolhaController::class,
            'store',
            \Modules\Questionario\Http\Requests\QuestionarioPerguntaEscolhaStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $questionario_pergunta = factory(QuestionarioPergunta::class)->create();
        $tipo = $this->faker->randomElement(/** enum_attributes **/);
        $outro_informar = $this->faker->boolean;

        $response = $this->post(route('questionario-pergunta-escolha.store'), [
            'questionario_pergunta_id' => $questionario_pergunta->id,
            'tipo' => $tipo,
            'outro_informar' => $outro_informar,
        ]);

        $questionarioPerguntaEscolhas = QuestionarioPerguntaEscolha::query()
            ->where('questionario_pergunta_id', $questionario_pergunta->id)
            ->where('tipo', $tipo)
            ->where('outro_informar', $outro_informar)
            ->get();
        $this->assertCount(1, $questionarioPerguntaEscolhas);
        $questionarioPerguntaEscolha = $questionarioPerguntaEscolhas->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $questionarioPerguntaEscolha = factory(QuestionarioPerguntaEscolha::class)->create();

        $response = $this->get(route('questionario-pergunta-escolha.show', $questionarioPerguntaEscolha));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioPerguntaEscolhaController::class,
            'update',
            \Modules\Questionario\Http\Requests\QuestionarioPerguntaEscolhaUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $questionarioPerguntaEscolha = factory(QuestionarioPerguntaEscolha::class)->create();
        $questionario_pergunta = factory(QuestionarioPergunta::class)->create();
        $tipo = $this->faker->randomElement(/** enum_attributes **/);
        $outro_informar = $this->faker->boolean;

        $response = $this->put(route('questionario-pergunta-escolha.update', $questionarioPerguntaEscolha), [
            'questionario_pergunta_id' => $questionario_pergunta->id,
            'tipo' => $tipo,
            'outro_informar' => $outro_informar,
        ]);

        $questionarioPerguntaEscolha->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($questionario_pergunta->id, $questionarioPerguntaEscolha->questionario_pergunta_id);
        $this->assertEquals($tipo, $questionarioPerguntaEscolha->tipo);
        $this->assertEquals($outro_informar, $questionarioPerguntaEscolha->outro_informar);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $questionarioPerguntaEscolha = factory(QuestionarioPerguntaEscolha::class)->create();

        $response = $this->delete(route('questionario-pergunta-escolha.destroy', $questionarioPerguntaEscolha));

        $response->assertNoContent();

        $this->assertDeleted($questionarioPerguntaEscolha);
    }
}
