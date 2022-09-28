<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Modules\EmpresaAlteracao\Entities\EmpresaAlteracao;
use Tests\TestCase;

/**
 * @see \Modules\EmpresaAlteracao\Http\Controllers\EmpresaAlteracaoController
 */
class EmpresaAlteracaoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $empresaAlteracaos = factory(EmpresaAlteracao::class, 3)->create();

        $response = $this->get(route('empresa-alteracao.index'));
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\EmpresaAlteracao\Http\Controllers\EmpresaAlteracaoController::class,
            'store',
            \Modules\EmpresaAlteracao\Http\Requests\EmpresaAlteracaoStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $empresaAlteracao = $this->faker->word;

        $response = $this->post(route('empresa-alteracao.store'), [
            'empresaAlteracao' => $empresaAlteracao,
        ]);

        $empresaAlteracaos = EmpresaAlteracao::query()
            ->where('empresaAlteracao', $empresaAlteracao)
            ->get();
        $this->assertCount(1, $empresaAlteracaos);
        $empresaAlteracao = $empresaAlteracaos->first();
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $empresaAlteracao = factory(EmpresaAlteracao::class)->create();

        $response = $this->get(route('empresa-alteracao.show', $empresaAlteracao));
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \Modules\EmpresaAlteracao\Http\Controllers\EmpresaAlteracaoController::class,
            'update',
            \Modules\EmpresaAlteracao\Http\Requests\EmpresaAlteracaoUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $empresaAlteracao = factory(EmpresaAlteracao::class)->create();
        $empresaAlteracao = $this->faker->word;

        $response = $this->put(route('empresa-alteracao.update', $empresaAlteracao), [
            'empresaAlteracao' => $empresaAlteracao,
        ]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $empresaAlteracao = factory(EmpresaAlteracao::class)->create();

        $response = $this->delete(route('empresa-alteracao.destroy', $empresaAlteracao));

        $response->assertOk();

        $this->assertDeleted($empresaAlteracao);
    }
}
