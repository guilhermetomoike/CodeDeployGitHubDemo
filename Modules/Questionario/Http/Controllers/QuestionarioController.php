<?php

namespace Modules\Questionario\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Questionario\Entities\Questionario;
use Modules\Questionario\Entities\QuestionarioResposta;
use Modules\Questionario\Http\Resources\QuestionarioResource;
use Modules\Questionario\Http\Resources\QuestionarioCollection;
use Modules\Questionario\Http\Requests\QuestionarioStoreRequest;
use Modules\Questionario\Http\Requests\QuestionarioUpdateRequest;
use Modules\Questionario\Http\Requests\QuestionarioEstaticoStoreRequest;

class QuestionarioController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioCollection
     */
    public function index(Request $request)
    {
        $questionarios = Questionario::all();

        return new QuestionarioCollection($questionarios);
    }

    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioStoreRequest $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioResource
     */
    public function store(QuestionarioStoreRequest $request)
    {
        $questionario = Questionario::create($request->validated());

        return new QuestionarioResource($questionario);
    }


    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioEstaticoStoreRequest $request
     * @return \Modules\Questionario\Http\Resources\QuestionarioResource
     */
    public function estatico(QuestionarioEstaticoStoreRequest $request)
    {
        $respostas = $request->validated();

        if ($this->jaRespondeu(1, $respostas['customer_id'])) {
            QuestionarioResposta::where('respondente', $respostas['customer_id'])->delete();
        }

        $items = [];

        array_push($items, [
            'respondente' => $respostas['customer_id'],
            'questionario_pergunta_id' => 1,
            'questionario_pergunta_escolha_id' => $respostas['etapa_carreira'],
            'resposta' => null
        ]);

        if ($respostas['etapa_carreira_especialidade']) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 2,
                'questionario_pergunta_escolha_id' => null,
                'resposta' => $respostas['etapa_carreira_especialidade']
            ]);
        }

        if ($respostas['etapa_carreira_instituicao']) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 3,
                'questionario_pergunta_escolha_id' => null,
                'resposta' => $respostas['etapa_carreira_instituicao']
            ]);
        }

        array_push($items, [
            'respondente' => $respostas['customer_id'],
            'questionario_pergunta_id' => 4,
            'questionario_pergunta_escolha_id' => $respostas['graduacao_instituicao_tipo'],
            'resposta' => null
        ]);

        if ($respostas['graduacao_instituicao_nome']) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 5,
                'questionario_pergunta_escolha_id' => null,
                'resposta' => $respostas['graduacao_instituicao_nome']
            ]);
        }

        if ($respostas['graduacao_conclusao_ano']) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 6,
                'questionario_pergunta_escolha_id' => null,
                'resposta' => $respostas['graduacao_conclusao_ano']
            ]);
        }

        array_push($items, [
            'respondente' => $respostas['customer_id'],
            'questionario_pergunta_id' => 7,
            'questionario_pergunta_escolha_id' => $respostas['financiamento_estudantil'],
            'resposta' => null
        ]);

        if (in_array('financiamento_estudantil_outro', $respostas)) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 7,
                'questionario_pergunta_escolha_id' => 10,
                'resposta' => $respostas['financiamento_estudantil_outro']
            ]);
        }

        foreach ($respostas['local_atendimento'] as $key => $value) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 8,
                'questionario_pergunta_escolha_id' => $value,
                'resposta' => null
            ]);
        }

        if (in_array('local_atendimento_outro', $respostas)) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 8,
                'questionario_pergunta_escolha_id' => 21,
                'resposta' => $respostas['local_atendimento_outro']
            ]);
        }

        array_push($items, [
            'respondente' => $respostas['customer_id'],
            'questionario_pergunta_id' => 9,
            'questionario_pergunta_escolha_id' => $respostas['faturamento_mensal'],
            'resposta' => null
        ]);

        if ($respostas['faturamento_mensal_sonho']) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 10,
                'questionario_pergunta_escolha_id' => null,
                'resposta' => $respostas['faturamento_mensal_sonho']
            ]);
        }

        foreach ($respostas['contrato_recebimento'] as $key => $value) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 11,
                'questionario_pergunta_escolha_id' => $value,
                'resposta' => null
            ]);
        }

        foreach ($respostas['fonte_alternativa'] as $key => $value) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 12,
                'questionario_pergunta_escolha_id' => $value,
                'resposta' => null
            ]);
        }

        if (in_array('fonte_alternativa_outro', $respostas)) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 12,
                'questionario_pergunta_escolha_id' => 39,
                'resposta' => $respostas['fonte_alternativa_outro']
            ]);
        }

        if ($respostas['horas_semanal_trabalhada']) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 13,
                'questionario_pergunta_escolha_id' => null,
                'resposta' => $respostas['horas_semanal_trabalhada']
            ]);
        }

        if ($respostas['horas_pretendida_trabalhada']) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 14,
                'questionario_pergunta_escolha_id' => null,
                'resposta' => $respostas['horas_pretendida_trabalhada']
            ]);
        }

        if ($respostas['objetivos_futuros']) {
            array_push($items, [
                'respondente' => $respostas['customer_id'],
                'questionario_pergunta_id' => 15,
                'questionario_pergunta_escolha_id' => null,
                'resposta' => $respostas['objetivos_futuros']
            ]);
        }

        QuestionarioResposta::insert($items);
        return response()->json(true, 201);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\Questionario $questionario
     * @return \Modules\Questionario\Http\Resources\QuestionarioResource
     */
    public function show(Request $request, Questionario $questionario)
    {
        return new QuestionarioResource($questionario);
    }


    /**
     * @param $id
     * @return \Modules\Questionario\Http\Resources\QuestionarioResource
     */
    public function full($id)
    {
        $questionario = Questionario::find($id);
        $questionario->load('questionarioPaginas.questionarioPartes.questionarioPerguntas.questionarioPerguntaEscolhas');

        return new QuestionarioResource($questionario);
    }

    /**
     * @param $id
     * @param $customer_id
     * @return boolean
     */
    public function respondeu($id, $customer_id)
    {
        return new JsonResponse($this->jaRespondeu($id, $customer_id));
    }

    private static function jaRespondeu($id, $customer_id)
    {
        $exists =  (QuestionarioResposta::where('respondente', $customer_id)
            ->join('questionario_perguntas', 'questionario_pergunta_id', '=', 'questionario_perguntas.id')
            ->join('questionario_partes', 'questionario_parte_id', '=', 'questionario_partes.id')
            ->join('questionario_paginas', 'questionario_pagina_id', '=', 'questionario_paginas.id')
            ->join('questionarios', 'questionario_id', '=', 'questionarios.id')
            ->where('questionarios.id', $id)
            ->exists() == 1 ?  true : false);

        return $exists;
    }


    /**
     * @param \Modules\Questionario\Http\Requests\QuestionarioUpdateRequest $request
     * @param \Modules\Questionario\Entities\Questionario $questionario
     * @return \Modules\Questionario\Http\Resources\QuestionarioResource
     */
    public function update(QuestionarioUpdateRequest $request, Questionario $questionario)
    {
        $questionario->update($request->validated());

        return new QuestionarioResource($questionario);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Questionario\Entities\Questionario $questionario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Questionario $questionario)
    {
        $questionario->delete();

        return response()->noContent();
    }
}
