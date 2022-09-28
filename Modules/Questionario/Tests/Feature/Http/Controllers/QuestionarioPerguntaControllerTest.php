<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Questionario\Entities\QuestionarioParte;
use Modules\Questionario\Entities\QuestionarioPergunta;
use Modules\Questionario\Entities\QuestionarioPerguntum;

/**
 * @see \Modules\Questionario\Http\Controllers\QuestionarioPerguntaController
 */
class QuestionarioPerguntaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $questionarioPergunta = factory(QuestionarioPergunta::class, 3)->create();

        $response = $this->get(route('questionario-perguntum.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioPerguntaController::class,
            'store',
            \Modules\Questionario\Http\Requests\QuestionarioPerguntaStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $questionario_parte = factory(QuestionarioParte::class)->create();
        $obrigatoria = $this->faker->boolean;
        $tipo = $this->faker->randomElement(/** enum_attributes **/);
        $min = $this->faker->numberBetween(-10000, 10000);
        $max = $this->faker->numberBetween(-10000, 10000);
        $mostrar_se_resposta = $this->faker->word;

        $response = $this->post(route('questionario-perguntum.store'), [
            'questionario_parte_id' => $questionario_parte->id,
            'obrigatoria' => $obrigatoria,
            'tipo' => $tipo,
            'min' => $min,
            'max' => $max,
            'mostrar_se_resposta' => $mostrar_se_resposta,
        ]);

        $questionarioPergunta = QuestionarioPergunta::query()
            ->where('questionario_parte_id', $questionario_parte->id)
            ->where('obrigatoria', $obrigatoria)
            ->where('tipo', $tipo)
            ->where('min', $min)
            ->where('max', $max)
            ->where('mostrar_se_resposta', $mostrar_se_resposta)
            ->get();
        $this->assertCount(1, $questionarioPergunta);
        $questionarioPerguntum = $questionarioPergunta->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $questionarioPerguntum = factory(QuestionarioPergunta::class)->create();

        $response = $this->get(route('questionario-perguntum.show', $questionarioPerguntum));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\Questionario\Http\Controllers\QuestionarioPerguntaController::class,
            'update',
            \Modules\Questionario\Http\Requests\QuestionarioPerguntaUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $questionarioPerguntum = factory(QuestionarioPergunta::class)->create();
        $questionario_parte = factory(QuestionarioParte::class)->create();
        $obrigatoria = $this->faker->boolean;
        $tipo = $this->faker->randomElement(/** enum_attributes **/);
        $min = $this->faker->numberBetween(-10000, 10000);
        $max = $this->faker->numberBetween(-10000, 10000);
        $mostrar_se_resposta = $this->faker->word;

        $response = $this->put(route('questionario-perguntum.update', $questionarioPerguntum), [
            'questionario_parte_id' => $questionario_parte->id,
            'obrigatoria' => $obrigatoria,
            'tipo' => $tipo,
            'min' => $min,
            'max' => $max,
            'mostrar_se_resposta' => $mostrar_se_resposta,
        ]);

        $questionarioPerguntum->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($questionario_parte->id, $questionarioPerguntum->questionario_parte_id);
        $this->assertEquals($obrigatoria, $questionarioPerguntum->obrigatoria);
        $this->assertEquals($tipo, $questionarioPerguntum->tipo);
        $this->assertEquals($min, $questionarioPerguntum->min);
        $this->assertEquals($max, $questionarioPerguntum->max);
        $this->assertEquals($mostrar_se_resposta, $questionarioPerguntum->mostrar_se_resposta);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $questionarioPerguntum = factory(QuestionarioPergunta::class)->create();
        $questionarioPerguntum = factory(QuestionarioPerguntum::class)->create();

        $response = $this->delete(route('questionario-perguntum.destroy', $questionarioPerguntum));

        $response->assertNoContent();

        $this->assertDeleted($questionarioPerguntum);
    }
}
